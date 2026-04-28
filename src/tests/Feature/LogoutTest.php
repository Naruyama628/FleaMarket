<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // ログアウトを確認
    public function test_logout_success()
    {
        // ユーザーを作成
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password123'),
        ]);

        // 作成したユーザーで認証済みになる
        $this->actingAs($user);

        $this->assertAuthenticated();

        // ログアウト処理
        $response = $this->from('/logout')->post('/logout');

        // 未認証状態であることを確認
        $this->assertGuest();
    }
}
