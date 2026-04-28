<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Profile;


class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_payment_method_change_is_reflected_in_summary()
    {
        // 出品者用ユーザーを作成
        $userSeller = User::factory()->create([
            'email' => 'user_Seller@test.com',
            'password' => bcrypt('password123'),
        ]);

        // ログイン用ユーザーを作成
        $buyer = User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('password123'),
        ]);

        // プロフィール作成
        Profile::factory()->create([
            'user_id' => $buyer->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル',
        ]);

        // 商品を作成
        $product = Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => '腕時計',
            'brand' => 'Rolex',
            'description' => '高級時計です',
            'price' => 20000,
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        // ログイン用ユーザーでログイン
        $response = $this->from('/login')->post('/login',[
            'email' => 'user@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();

        // 購入した商品一覧画面に遷移
        $response = $this->get('/purchase/' . $product->id);
        $response->assertStatus(200);

        // 小計画面の支払い選択がデフォルトになっていることを確認
        $response->assertSee('<p class="order-summary__value">選択してください</p>', false);

        $response = $this->get('/purchase/' . $product->id . '?payment_method=card');

        $response->assertStatus(200);
        $response->assertSee('<p class="order-summary__value">カード</p>', false);
    }
}
