<?php

namespace Tests\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\RegisterController::store
     */
    public function it_registers_a_user()
    {
        $response = $this->json('post', route('register.store'), [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'andrew',
            'password_confirmation' => 'andrew',
        ]);

        $response->assertRedirect(route('diary'));
        $response->assertSessionHas('success', 'Hello, John');
        $this->assertEquals(1, User::count());
        $user = User::first();
        $this->assertTrue(auth()->user()->is($user));
        $this->assertTrue(Hash::check('andrew', $user->password));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\RegisterController::store
     */
    public function it_doesnt_register_if_passwords_dont_match()
    {
        $response = $this->json('post', route('register.store'), [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'andrew',
            'password_confirmation' => 'na-ah',
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, User::count());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\RegisterController::store
     */
    public function it_doesnt_register_if_email_is_invalid()
    {
        $response = $this->json('post', route('register.store'), [
            'name' => 'John',
            'email' => 'not-email',
            'password' => 'andrew',
            'password_confirmation' => 'andrew',
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, User::count());
        $response->assertJsonValidationErrors('email');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Auth\RegisterController::store
     */
    public function it_doesnt_register_if_name_is_not_provided()
    {
        $response = $this->json('post', route('register.store'), [
            'name' => null,
            'email' => 'not-email@email.com',
            'password' => 'andrew',
            'password_confirmation' => 'andrew',
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, User::count());
        $response->assertJsonValidationErrors('name');
    }
}
