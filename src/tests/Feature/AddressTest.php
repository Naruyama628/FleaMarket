<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Models\Product;
use App\Models\Order;

class AddressTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function  test_changed_shipping_address_is_reflected_in_purchase_summary()
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
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区1-1-1');
        $response->assertSee('テストビル');

        $response = $this->get('/purchase/address/' . $product->id);
        $response->assertStatus(200);

        $response = $this->post('/purchase/address/' ,[
            'item_id' => $product->id,
            'postal_code' => '111-2222',
            'address' => '東京都渋谷区2-2-2',
            'building' => 'テストタワー',
        ]);
        $response->assertStatus(200);

        $response->assertSee('111-2222');
        $response->assertSee('東京都渋谷区2-2-2');
        $response->assertSee('テストタワー');
    }

        public function test_changed_address_is_saved_to_order_address_on_purchase()
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

        $response = $this->post('/purchase/address/' ,[
            'item_id' => $product->id,
            'postal_code' => '111-2222',
            'address' => '東京都渋谷区2-2-2',
            'building' => 'テストタワー',
        ]);
        $response->assertStatus(200);

        $response = $this->post('/purchase/' . $product->id . '/checkout', [
            'payment_method' => 'コンビニ払い',
            'postal_code' => '111-2222',
            'address' => '東京都渋谷区2-2-2',
            'building' => 'テストタワー',
        ]);
        $response->assertRedirectContains('checkout.stripe.com');

        $payload = json_encode([
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'amount_total' => 20000,
                    'metadata' => [
                        'product_id' => $product->id,
                        'user_id' => $buyer->id,
                        'postal_code' => '111-2222',
                        'address' => '東京都渋谷区2-2-2',
                        'building' => 'テストタワー',
                        'payment_method' => 'konbini',
                    ],
                ],
            ],
        ]);

        $response = $this->call(
            'POST',
            '/stripe/webhook',
            [],
            [],
            [],
            [
                'HTTP_STRIPE_SIGNATURE' => 'test',
                'CONTENT_TYPE' => 'application/json',
            ],
            $payload
        );
        $response->assertStatus(200);

        $this->assertDatabaseHas('order_addresses', [
            'postal_code' => '111-2222',
            'address' => '東京都渋谷区2-2-2',
            'building' => 'テストタワー',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'purchased_price' => 20000,
        ]);

        $order = Order::first();
        $this->assertNotNull($order);
        $this->assertNotNull($order->order_address_id);
    }
}
