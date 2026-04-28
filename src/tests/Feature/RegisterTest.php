<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // 名前のバリデーション確認
    public function test_name_required()
    {
        // 名前を入力せずにユーザー登録処理
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // バリデーションエラー、バリデーションメッセージが正しいことを確認
        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);
    }

    // メールアドレスのバリデーション確認
    public function test_email_required()
    {
    // メールアドレスを入力せずにユーザー登録処理
        $response = $this->post('/register', [
            'name' => 'taro',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // バリデーションエラー、バリデーションメッセージが正しいことを確認
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    // パスワードのバリデーション確認
    public function test_password_required()
    {
        // パスワードを入力せずにユーザー登録処理
        $response = $this->post('/register', [
            'name' => 'taro',
            'email' => 'test@test.com',
            'password' => '',
            'password_confirmation' => 'password123',
        ]);

        // バリデーションエラー、バリデーションメッセージが正しいことを確認
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    // パスワードの文字数のバリデーションを確認
    public function test_password_min()
    {
    // パスワードを8文字未満で入力し、ユーザー登録処理
        $response = $this->post('/register', [
            'name' => 'taro',
            'email' => 'test@test.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);

        // バリデーションエラー、バリデーションメッセージが正しいことを確認
        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }

    // 確認用パスワードのバリデーションを確認
    public function test_password_confirmation_mismatch()
    {
        // パスワードと確認用パスワードが相違した状態でユーザー登録処理
        $response = $this->post('/register', [
            'name' => 'taro',
            'email' => 'test@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password1234',
        ]);

        // バリデーションエラー、バリデーションメッセージが正しいことを確認
        $response->assertSessionHasErrors([
            'password' => 'パスワードと一致しません',
        ]);
    }

    // ユーザー登録が正しく行えるか確認
    public function test_register_success()
    {
        // ユーザー登録後リダイレクト
        $response = $this->followingRedirects()->post('/register', [
            'name' => 'taro',
            'email' => 'test@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'email_verified_at' => ''
        ]);
        
        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
        ]);

        // 認証が成功しているか確認
        $this->assertAuthenticated();

        // ユーザー登録後にプロフィール設定ページに遷移しているかを確認
        $response->assertSee('メール認証');
    }

    // ↓ここから応用

    public function test_verification_email_is_sent_after_registration()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'test@example.com')->first();

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_verify_button_links_to_mailtrap()
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/email/verify');

        $response->assertStatus(200);
        $response->assertSee('認証はこちらから');
        $response->assertSee('https://mailtrap.io/inboxes', false);
    }

    public function test_redirect_to_profile_edit_after_email_verification()
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect('/profile/edit');
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}


