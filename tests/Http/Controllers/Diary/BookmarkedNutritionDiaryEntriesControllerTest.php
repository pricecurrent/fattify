<?php

namespace Tests\Http\Controllers\Diary;

use App\Models\Bookmark;
use App\Models\NutritionDiaryEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BookmarkedNutritionDiaryEntriesControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\BookmarkedNutritionDiaryEntriesController::store
     */
    public function it_creates_a_bookmark_out_of_a_diary_entry()
    {
        $entry = NutritionDiaryEntry::factory()->create([
            'protein' => 10,
            'carbohydrates' => 20,
            'fat' => 5,
            'weight' => 50,
            'user_id' => $this->user->id,
            'dish_name' => 'Some cool name',
        ]);

        $response = $this->actingAs($this->user)->from('diary')->post(route('bookmarked-nutrition-diary-entries.store', $entry), [
            'name' => 'My Bookmark',
        ]);

        $response->assertRedirect('diary');
        $this->assertEquals(1, Bookmark::count());
        $bookmark = Bookmark::first();
        $this->assertEquals($bookmark->user_id, $this->user->id);
        $this->assertEquals('My Bookmark', $bookmark->name);
        $this->assertEquals(20, $bookmark->proteins);
        $this->assertEquals(40, $bookmark->carbs);
        $this->assertEquals(10, $bookmark->fats);
        $this->assertCarbon(now(), $entry->fresh()->bookmarked_at);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\BookmarkedNutritionDiaryEntriesController::store
     */
    public function it_can_not_create_a_bookmark_for_someone_elses_entry()
    {
        $entry = NutritionDiaryEntry::factory()->create([
            'protein' => 10,
            'carbohydrates' => 20,
            'fat' => 5,
            'weight' => 50,
            'user_id' => $this->user->id,
        ]);
        $evilUser = User::factory()->create();

        $response = $this->actingAs($evilUser)
            ->post(route('bookmarked-nutrition-diary-entries.store', $entry), [
                'name' => 'My Bookmark',
            ]);

        $response->assertStatus(403);
        $this->assertEquals(0, Bookmark::count());
    }
}
