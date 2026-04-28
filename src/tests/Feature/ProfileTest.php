<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Order;
use App\Models\OrderAddress;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_profile_page_displays_profile_and_product_information()
    {
        // ログイン用ユーザーを作成
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'user@test.com',
            'password' => bcrypt('password123'),
        ]);

        // プロフィール作成
        Profile::factory()->create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル',
            'profile_image' => 'test.jpg'
        ]);

        // 商品を作成
        $product = Product::factory()->create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolex',
            'description' => '高級時計です',
            'price' => 20000,
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        // 購入商品
        $otherUser = User::factory()->create();
        $purchasedProduct = Product::factory()->create([
            'user_id' => $otherUser->id,
            'name' => '購入商品',
            'brand' => 'none',
            'description' => 'テスト',
            'price' => 10000,
            'image' => 'test.jpg',
            'condition' => '良好',
            'is_sold' => true,
        ]);

        $orderAddress = OrderAddress::create([
            'postal_code' => '111-2222',
            'address' => '東京都渋谷区2-2-2',
            'building' => 'テストタワー',
        ]);

        Order::create([
            'user_id' => $user->id,
            'product_id' => $purchasedProduct->id,
            'order_address_id' => $orderAddress->id,
            'payment_method' => 'konbini',
            'purchased_price' => 20000,
            'purchased_at' => now(),
        ]);

        // ログイン用ユーザーでログイン
        $response = $this->from('/login')->post('/login',[
            'email' => 'user@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();

        $response = $this->get('/mypage');
        $response->assertStatus(200);

        // ユーザー名が表示される
        $response->assertSee('テストユーザー');

        // プロフィール画像が表示される
        $response->assertSee('test.jpg');

        // 出品商品一覧が表示される
        $response->assertSee('腕時計');

        $response = $this->get('/mypage/?page=buy');
        $response->assertStatus(200);

        // 購入商品一覧が表示される
        $response->assertSee('購入商品');
    }

        public function test_profile_edit_page_displays_updated_profile_information()
    {
        // ログイン用ユーザーを作成
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'user@test.com',
            'password' => bcrypt('password123'),
        ]);

        // プロフィール作成
        Profile::factory()->create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル',
            'profile_image' => 'test.jpg'
        ]);

        // ログイン用ユーザーでログイン
        $response = $this->from('/login')->post('/login',[
            'email' => 'user@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();

        $response = $this->post('/profile/edit', [
            'name' => '変更後ユーザー',
            'postal_code' => '098-7654',
            'address' => '東京都渋谷区2-2-2',
            'building' => 'テストタワー',
            'image' => '',
        ]);
        $response->assertStatus(302);

        $response = $this->get('/profile/edit');
        $response->assertStatus(200);

        // ユーザー名が表示される
        $response->assertSee('変更後ユーザー');

        // プロフィール画像が表示される
        $response->assertSee('test.jpg');

        // 郵便番号が表示される
        $response->assertSee('098-7654');

        // 住所が表示される
        $response->assertSee('東京都渋谷区2-2-2');

        // 建物名が表示される
        $response->assertSee('テストタワー');
    }

}
