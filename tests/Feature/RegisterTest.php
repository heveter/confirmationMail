<?php

namespace Tests\Feature;

use App\Mail\NotificationMail;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    public function testRegister()
    {
        Mail::fake();
        $response = $this->post(route('auth.register'), [
            'name' => fake()->name,
            'email' => fake()->email(),
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user_id',
            'token'
        ]);

        $userId = $response->json('user_id');
        $authToken = $response->json('token');
        Mail::assertSent(NotificationMail::class);

        $confirmCode = Cache::get('confirm_code_' . $userId);
        $this->assertNotEmpty($confirmCode);

        $response = $this->post(route('auth.confirmation-email'), [
            'code' => $confirmCode
        ], [
            'Authorization' => 'Bearer ' . $authToken
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['status']);
        $this->assertTrue($response->json('status'));

        $user = User::query()->where('id', $userId)->first();
        $this->assertNotNull($user);
        $this->assertNotNull($user->email_verified_at);
    }
}
