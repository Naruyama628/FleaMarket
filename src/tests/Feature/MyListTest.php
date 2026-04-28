<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class MyListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // マイリストを開いた際にいいねした商品だけ表示されるか
    public function test_only_liked_products_are_displayed()
    {
        // 出品車用ユーザーを作成
        $userSeller = User::factory()->create([
            'email' => 'user_Seller@test.com',
            'password' => bcrypt('password123'),
        ]);

        // ログイン用ユーザーを作成
        User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('password123'),
        ]);

        // 商品3つを作成
        $likeProduct = Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => '腕時計',
            'description' => 'like',
            'price' => 100,
            'image' => '',
        ]);

        Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => '置時計',
            'description' => 'like',
            'price' => 200,
            'image' => '',
        ]);

        Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => 'clock',
            'description' => 'none',
            'price' => 300,
            'image' => '',
        ]);

        // ログイン用ユーザーでログイン
        $response = $this->from('/login')->post('/login',[
            'email' => 'user@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();

        // 腕時計のみいいねする
        $response = $this->post('/like/' . $likeProduct->id);
        $response->assertStatus(302);

        // マイリスト画面に遷移
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        // いいねした商品は表示されて、いいねしていない商品は表示されないことを確認
        $response->assertSee('腕時計');
        $response->assertDontSee('置時計');
        $response->assertDontSee('clock');
    }

    // マイリスト画面でSoldラベルが表示されるか
    public function test_only_liked_sold_products_are_displayed_in_mylist()
    {
        // 出品車用ユーザーを作成
        $userSeller = User::factory()->create([
            'email' => 'user_Seller@test.com',
            'password' => bcrypt('password123'),
        ]);

        // ログイン用ユーザーを作成
        User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('password123'),
        ]);

        // 商品3つを作成
        // 腕時計を購入済みにする
        $likeProduct = Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => '腕時計',
            'description' => 'like',
            'price' => 100,
            'image' => '',
            'is_sold' => true,
        ]);

        Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => '置時計',
            'description' => 'like',
            'price' => 200,
            'image' => '',
        ]);

        Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => 'clock',
            'description' => 'none',
            'price' => 300,
            'image' => '',
        ]);

        // ログイン用ユーザーでログイン
        $response = $this->from('/login')->post('/login',[
            'email' => 'user@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();

        // 腕時計のみいいねする
        $response = $this->post('/like/' . $likeProduct->id);
        $response->assertStatus(302);

        // マイリスト画面に遷移
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        // いいねした商品は表示されて、いいねしていない商品は表示されないことを確認
        $response->assertSee('腕時計');
        $response->assertSee('Sold');
        $response->assertDontSee('置時計');
        $response->assertDontSee('clock');
    }

    // 未認証でマイリスト画面に遷移した場合、商品が何も表示されないか確認
    public function test_guest_cannot_see_products_in_mylist()
    {
        // 出品者用ユーザーを作成
        $userSeller = User::factory()->create([
            'email' => 'user_Seller@test.com',
            'password' => bcrypt('password123'),
        ]);

        // ログイン用ユーザーを作成
        User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('password123'),
        ]);

        // 商品3つを作成
        Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => '腕時計',
            'description' => 'like',
            'price' => 100,
            'image' => '',
        ]);

        Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => '置時計',
            'description' => 'like',
            'price' => 200,
            'image' => '',
        ]);

        Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => 'clock',
            'description' => 'none',
            'price' => 300,
            'image' => '',
        ]);

        // 未認証状態であることを確認
        $this->assertGuest();

        // マイリスト画面に遷移
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        // 商品が表示されないことを確認
        $response->assertDontSee('腕時計');
        $response->assertDontSee('置時計');
        $response->assertDontSee('clock');
    }
}
