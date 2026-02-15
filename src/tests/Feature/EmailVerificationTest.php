<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use App\Models\User;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_verification_email_is_sent_after_register()
    {
        Notification::fake();

        $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::where('email', 'test@example.com')->first();

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_verification_notice_page_contains_mailhog_link()
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)
            ->get(route('verification.notice'));

        $response->assertSee('認証はこちらから');
        $response->assertSee('http://localhost:8025');
    }

    public function test_user_can_verify_email()
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = \URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirectContains('/mypage/profile');
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
