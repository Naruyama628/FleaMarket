<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Profile;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // 商品が購入できるか確認
    public function test_purchase_is_completed()
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

        $response = $this->post('/purchase/' . $product->id . '/checkout', [
            'payment_method' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル',
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
                        'postal_code' => '123-4567',
                        'address' => '東京都',
                        'building' => 'テスト',
                        'payment_method' => 'card',
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

        // アドレスデータベースに登録されているか確認
        $this->assertDatabaseHas('order_addresses', [
            'postal_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テスト',
        ]);

        // 商品購入データベースに登録されているか確認
        $this->assertDatabaseHas('orders', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'payment_method' => 'card',
            'purchased_price' => 20000,
        ]);

        // 商品のis_soldフラグが更新されているか確認
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_sold' => true,
        ]);
    }

    // 購入した商品がマイページの購入済み一覧に表示されるか確認
    public function test_sold_label_is_displayed_for_sold_product()
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

        $response = $this->post('/purchase/' . $product->id . '/checkout', [
            'payment_method' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル',
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
                        'postal_code' => '123-4567',
                        'address' => '東京都',
                        'building' => 'テスト',
                        'payment_method' => 'card',
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

        // 商品一覧画面に遷移
        $response = $this->get('/');
        $response->assertStatus(200);

        // Soldラベルが表示されていることを確認
        $response->assertSee('Sold');
    }

    // 購入した商品が購入済み商品一覧で表示されるか
    public function test_sold_label_is_displayed_for_purchased_product()
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
            'profile_image' => 'test.jpg'
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

        $response = $this->post('/purchase/' . $product->id . '/checkout', [
            'payment_method' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル',
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
                        'postal_code' => '123-4567',
                        'address' => '東京都',
                        'building' => 'テスト',
                        'payment_method' => 'card',
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

        // 購入した商品一覧画面に遷移
        $response = $this->get('/mypage?page=buy');
        $response->assertStatus(200);

        // 購入した商品が表示されていることを確認
        $response->assertSee('Sold');
        $response->assertSee('腕時計');
    }
}
