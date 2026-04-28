<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // メールアドレスのバリデーション確認
    public function test_email_required()
    {
        // メールアドレスを入力せずにログイン処理をする
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        // バリデーションエラー、バリデーションメッセージが正しいことを確認
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    // メールアドレスのバリデーション確認
    public function test_password_required()
    {
        // パスワードを入力せずにログイン処理をする
        $response = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => '',
        ]);

        // バリデーションエラー、バリデーションメッセージが正しいことを確認
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    // ログイン失敗を確認
    public function test_login_fails_with_invalid_credentials()
    {
        // ユーザーを作成
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password123'),
        ]);

        // 間違えたログイン情報を送信
        $response = $this->from('/login')->post('/login',[
            'email' => 'test@test.com',
            'password' => 'password1234',
        ]);

        // バリデーションエラー、バリデーションメッセージが正しいことを確認
        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);

        $this->assertGuest();
    }

    // ログイン処理の確認
    public function test_login_success()
    {
        // ユーザーを作成
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password123'),
        ]);

        // 正しいログイン情報を送信
        $response = $this->from('/login')->post('/login',[
            'email' => 'test@test.com',
            'password' => 'password123',
        ]);

        // 認証済みになることを確認
        $this->assertAuthenticated();
    }
}
