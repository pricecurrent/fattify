<?php

namespace Tests\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\UsersController::update
     */
    public function it_updates_user_details()
    {
        Storage::fake('avatars');
        $this->user->update([
            'bio' => 'hello',
            'name' => 'jack',
            'avatar' => null,
        ]);

        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->user)->json('put', route('users.update', $this->user), [
            'name' => 'new name',
            'bio' => 'new bio',
            'avatar' => $file = UploadedFile::fake()->image('avatar.png'),
        ]);

        $response->assertRedirect(route('profile'));
        $this->user->refresh();
        $this->assertEquals('new name', $this->user->name);
        $this->assertEquals('new bio', $this->user->bio);
        $this->assertNotNull($this->user->avatar);
        Storage::disk('avatars')->assertExists($this->user->avatar);
    }
}
