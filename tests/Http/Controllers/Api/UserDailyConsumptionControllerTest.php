<?php

namespace Tests\Http\Controllers\Api;

use App\Models\NutritionDiaryEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserDailyConsumptionControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @covers \App\Http\Controllers\Api\UserDailyConsumptionController
     */
    public function it_fetches_daily_consumption_information_for_a_user()
    {
        $user = User::factory()->create([
            'daily_calories_goal' => 1000
        ]);
        NutritionDiaryEntry::factory()->create([
            'user_id' => $user->id,
            'calorie' => 100,
            'fat' => 10,
            'protein' => 20,
            'carbohydrates' => 30,
            'date' => today(),
        ]);
        NutritionDiaryEntry::factory()->create([
            'user_id' => $user->id,
            'calorie' => 100,
            'fat' => 10,
            'protein' => 20,
            'carbohydrates' => 30,
            'date' => today(),
        ]);

        $response = $this->be($user)->json('get', route('api.daily-consumption'));

        $response->assertOk();
        $data = $response->json('data');
        $this->assertEquals(200, $data['calories']);
        $this->assertEquals(60, $data['carbs']);
        $this->assertEquals(40, $data['proteins']);
        $this->assertEquals(20, $data['fats']);
        $this->assertEquals(0.2, $data['percentage']);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Api\UserDailyConsumptionController
     */
    public function it_fetches_daily_consumption_information_for_a_user_on_a_requested_date()
    {
        $user = User::factory()->create([
            'daily_calories_goal' => 1000
        ]);
        NutritionDiaryEntry::factory()->create([
            'user_id' => $user->id,
            'calorie' => 100,
            'fat' => 10,
            'protein' => 20,
            'carbohydrates' => 30,
            'date' => today()->subWeek(),
        ]);
        NutritionDiaryEntry::factory()->create([
            'user_id' => $user->id,
            'calorie' => 100,
            'fat' => 10,
            'protein' => 20,
            'carbohydrates' => 30,
            'date' => today(),
        ]);

        $response = $this->be($user)->json('get', route('api.daily-consumption', ['date' => today()->subWeek()->toDateString()]));

        $response->assertOk();
        $data = $response->json('data');
        $this->assertEquals(100, $data['calories']);
        $this->assertEquals(30, $data['carbs']);
        $this->assertEquals(20, $data['proteins']);
        $this->assertEquals(10, $data['fats']);
        $this->assertEquals(0.1, $data['percentage']);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Api\UserDailyConsumptionController
     */
    public function it_ignores_other_users_entries()
    {
        $user = User::factory()->create([
            'daily_calories_goal' => 1000
        ]);
        NutritionDiaryEntry::factory()->create([
            'user_id' => $user->id,
            'calorie' => 100,
            'fat' => 10,
            'protein' => 20,
            'carbohydrates' => 30,
            'date' => today(),
        ]);
        // some other user entry
        NutritionDiaryEntry::factory()->create([
            'calorie' => 100,
            'fat' => 10,
            'protein' => 20,
            'carbohydrates' => 30,
            'date' => today(),
        ]);

        $response = $this->be($user)->json('get', route('api.daily-consumption'));

        $response->assertOk();
        $data = $response->json('data');
        $this->assertEquals(100, $data['calories']);
        $this->assertEquals(30, $data['carbs']);
        $this->assertEquals(20, $data['proteins']);
        $this->assertEquals(10, $data['fats']);
        $this->assertEquals(0.1, $data['percentage']);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Api\UserDailyConsumptionController
     */
    public function it_shows_0_for_when_there_are_no_entries()
    {
        $user = User::factory()->create([
            'daily_calories_goal' => 1000
        ]);

        $response = $this->be($user)->json('get', route('api.daily-consumption'));

        $response->assertOk();
        $data = $response->json('data');
        $this->assertSame(0, $data['calories']);
        $this->assertSame(0, $data['carbs']);
        $this->assertSame(0, $data['proteins']);
        $this->assertSame(0, $data['fats']);
        $this->assertSame(0, $data['percentage']);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Api\UserDailyConsumptionController
     */
    public function it_uses_todays_date_if_cant_understdand_whats_passed_in()
    {
        $user = User::factory()->create([
            'daily_calories_goal' => 1000
        ]);
        NutritionDiaryEntry::factory()->create([
            'user_id' => $user->id,
            'calorie' => 100,
            'fat' => 10,
            'protein' => 20,
            'carbohydrates' => 30,
            'date' => today(),
        ]);

        $response = $this->be($user)->json('get', route('api.daily-consumption'), ['date' => 'foo']);

        $response->assertOk();
        $data = $response->json('data');
        $this->assertEquals(100, $data['calories']);
        $this->assertEquals(30, $data['carbs']);
        $this->assertEquals(20, $data['proteins']);
        $this->assertEquals(10, $data['fats']);
        $this->assertEquals(0.1, $data['percentage']);
    }
}
