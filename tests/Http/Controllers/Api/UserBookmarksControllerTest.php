<?php

namespace Tests\Http\Controllers\Api;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserBookmarksControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Api\UserBookmarksController::index
     */
    public function it_fetches_users_bookmarks()
    {
        $bookmarkA = Bookmark::factory()->create(['user_id' => $this->user->id, 'name' => 'Foo']);
        $bookmarkB = Bookmark::factory()->create(['user_id' => $this->user->id, 'name' => 'Bar']);

        $response = $this->actingAs($this->user)->json('get', route('api.user-bookmarks.index', $this->user));

        $response->assertOk();
        $response->assertJsonHasModel($bookmarkA);
        $response->assertJsonHasModel($bookmarkB);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Api\UserBookmarksController::index
     */
    public function it_doesnt_fetch_other_users_bookmarks()
    {
        $bookmarkA = Bookmark::factory()->create(['user_id' => $this->user->id]);
        $bookmarkB = Bookmark::factory()->create(['user_id' => $this->user->id]);
        $anotherUserBookmark = Bookmark::factory()->create();

        $response = $this->actingAs($this->user)->json('get', route('api.user-bookmarks.index', $this->user));

        $response->assertOk();
        $response->assertJsonHasModel($bookmarkA);
        $response->assertJsonHasModel($bookmarkB);
    }

    /**
     * @test
     * @covers
     */
    public function it_fetches_users_bookmarks_sorted_by_frequency_of_use()
    {
        $bookmarkA = Bookmark::factory()->create(['user_id' => $this->user->id, 'last_used_at' => now()->subHours(3)]);
        $bookmarkB = Bookmark::factory()->create(['user_id' => $this->user->id, 'last_used_at' => now()->subHours(1)]);
        $bookmarkC = Bookmark::factory()->create(['user_id' => $this->user->id, 'last_used_at' => now()->subHours(2)]);

        $response = $this->actingAs($this->user)->json('get', route('api.user-bookmarks.index', $this->user));

        $response->assertOk();
        $response->assertJsonHasModel($bookmarkA);
        $response->assertJsonHasModel($bookmarkB);
        $response->assertJsonHasModel($bookmarkC);
        $response->assertJsonSortedById([$bookmarkB, $bookmarkC, $bookmarkA]);
    }

    /**
     * @test
     * @covers
     */
    public function it_fetches_users_bookmarks_filtered_by_keyword()
    {
        $bookmarkA = Bookmark::factory()->create(['name' => 'Banana', 'user_id' => $this->user->id]);
        $bookmarkB = Bookmark::factory()->create(['name' => 'Apple', 'user_id' => $this->user->id]);
        $bookmarkC = Bookmark::factory()->create(['name' => 'Baran', 'user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->json('get', route('api.user-bookmarks.index', $this->user), [
                'search' => 'ba',
            ]);

        $response->assertOk();
        $response->assertJsonHasModel($bookmarkA);
        $response->assertJsonDoesntHaveModel($bookmarkB);
        $response->assertJsonHasModel($bookmarkC);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Api\UserBookmarksController::index
     */
    public function it_can_not_fetch_bookmarks_for_guest()
    {
        $bookmarkA = Bookmark::factory()->create(['user_id' => $this->user->id]);
        $bookmarkB = Bookmark::factory()->create(['user_id' => $this->user->id]);

        $this->json('get', route('api.user-bookmarks.index', $this->user))
            ->assertUnauthorized();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Api\UserBookmarksController::index
     */
    public function it_can_not_fetch_someone_elses_bookmarks()
    {
        $bookmarkA = Bookmark::factory()->create(['user_id' => $this->user->id]);
        $bookmarkB = Bookmark::factory()->create(['user_id' => $this->user->id]);
        $evil = User::factory()->create();

        $this
            ->actingAs($evil)
            ->json('get', route('api.user-bookmarks.index', $this->user))
            ->assertForbidden();
    }
}
