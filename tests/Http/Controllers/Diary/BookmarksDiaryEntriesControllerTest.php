<?php

namespace Tests\Http\Controllers\Diary;

use App\Models\Bookmark;
use App\Models\NutritionDiaryEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BookmarksDiaryEntriesControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\BookmarksDiaryEntriesController::store
     */
    public function it_stores_a_diary_entry_out_of_bookmark()
    {
        $bookmark = Bookmark::factory()->create(['user_id' => $this->user->id]);
        $this->assertCount(0, $this->user->nutritionDiaryEntries);

        $response = $this->actingAs($this->user)->post(route('nutrition-diary-entries.bookmarks.store'), [
            'bookmark_id' => $bookmark->id,
            'weight' => '100',
            'meal_time' => 'breakfast',
        ]);

        $response->assertRedirect(route('diary'));
        $this->assertCount(1, $this->user->nutritionDiaryEntries()->get());
        $this->assertEquals('breakfast', NutritionDiaryEntry::first()->meal_time);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\BookmarksDiaryEntriesController::store
     */
    public function it_cant_store_an_entry_for_a_guest()
    {
        $bookmark = Bookmark::factory()->create(['user_id' => $this->user->id]);
        $this->assertCount(0, $this->user->nutritionDiaryEntries);

        $response = $this->post(route('nutrition-diary-entries.bookmarks.store'), [
            'bookmark_id' => $bookmark->id,
            'weight' => '100',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertCount(0, $this->user->nutritionDiaryEntries()->get());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\BookmarksDiaryEntriesController::store
     */
    public function bookmark_is_required_to_store_an_entry()
    {
        $bookmark = Bookmark::factory()->create(['user_id' => $this->user->id]);
        $this->assertCount(0, $this->user->nutritionDiaryEntries);

        $response = $this->actingAs($this->user)
            ->from(route('diary'))
            ->post(route('nutrition-diary-entries.bookmarks.store'), [
                'bookmark_id' => null,
                'weight' => '100',
            ]);

        $response->assertRedirect(route('diary'));
        $response->assertSessionHasErrors('bookmark_id');
        $this->assertCount(0, $this->user->nutritionDiaryEntries()->get());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\BookmarksDiaryEntriesController::store
     */
    public function bookmark_must_be_valid_id()
    {
        $this->assertCount(0, $this->user->nutritionDiaryEntries);

        $response = $this->actingAs($this->user)
            ->from(route('diary'))
            ->post(route('nutrition-diary-entries.bookmarks.store'), [
                'bookmark_id' => 9999,
                'weight' => '100',
            ]);

        $response->assertRedirect(route('diary'));
        $response->assertSessionHasErrors('bookmark_id');
        $this->assertCount(0, $this->user->nutritionDiaryEntries()->get());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\BookmarksDiaryEntriesController::store
     */
    public function weight_is_required_to_create_an_entry()
    {
        $bookmark = Bookmark::factory()->create();
        $this->assertCount(0, $this->user->nutritionDiaryEntries);

        $response = $this->actingAs($this->user)
            ->from(route('diary'))
            ->post(route('nutrition-diary-entries.bookmarks.store'), [
                'bookmark_id' => $bookmark->id,
                'weight' => '',
            ]);

        $response->assertRedirect(route('diary'));
        $response->assertSessionHasErrors('weight');
        $this->assertCount(0, $this->user->nutritionDiaryEntries()->get());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\BookmarksDiaryEntriesController::store
     */
    public function weight_must_be_positive_int()
    {
        $bookmark = Bookmark::factory()->create();

        $this->actingAs($this->user)
            ->from(route('diary'))
            ->post(route('nutrition-diary-entries.bookmarks.store'), [
                'bookmark_id' => $bookmark->id,
                'weight' => 'string',
            ])
            ->assertSessionHasErrors('weight');

        $this->actingAs($this->user)
            ->from(route('diary'))
            ->post(route('nutrition-diary-entries.bookmarks.store'), [
                'bookmark_id' => $bookmark->id,
                'weight' => 0,
            ])
            ->assertSessionHasErrors('weight');

        $this->actingAs($this->user)
            ->from(route('diary'))
            ->post(route('nutrition-diary-entries.bookmarks.store'), [
                'bookmark_id' => $bookmark->id,
                'weight' => 3.3,
            ])
            ->assertSessionHasErrors('weight');

        $this->assertCount(0, $this->user->nutritionDiaryEntries()->get());
    }
}
