<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class LikeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // いいねを押下した際の処理を確認
    public function test_like_count_increases_after_liking_product()
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

        // 商品ページへ遷移する
        $response = $this->get('/item/' . $product->id);
        $response->assertStatus(200);

        // いいね数が0であることを確認
        $response->assertDontSee('<p class="item-detail__action-count">1</p>', false);

        // いいねする
        $response = $this->post('/like/' . $product->id);
        $response->assertStatus(302);
        $response = $this->get('/item/' . $product->id);
        $response->assertStatus(200);

        // いいね数が1に増加していることを確認
        $response->assertSee('<p class="item-detail__action-count">1</p>', false);
    }

    // いいねを押下した際のアイコンの色を確認
    public function test_heart_icon_turns_pink_after_like()
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

        // 商品ページへ遷移する
        $response = $this->get('/item/' . $product->id);
        $response->assertStatus(200);

        // いいねアイコンがピンクでないことを確認
        $response->assertSee('img/ハートロゴ_デフォルト.png', false);
        $response->assertDontSee('img/ハートロゴ_ピンク.png', false);

        // いいねする
        $response = $this->post('/like/' . $product->id);
        $response->assertStatus(302);
        $response = $this->get('/item/' . $product->id);
        $response->assertStatus(200);

        // いいねアイコンがピンクになっていることを確認
        $response->assertDontSee('img/ハートロゴ_デフォルト.png', false);
        $response->assertSee('img/ハートロゴ_ピンク.png', false);
    }

    // いいねを再度押下した際の処理を確認
    public function test_like_is_removed_when_pressed_again()
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

        // いいねを押下する
        $response = $this->post('/like/' . $product->id);
        $response->assertStatus(302);

        // 商品ページへ遷移する
        $response = $this->get('/item/' . $product->id);
        $response->assertStatus(200);

        // いいね数が1であることを確認
        $response->assertSee('<p class="item-detail__action-count">1</p>', false);

        // 再度いいねを押下する
        $response = $this->post('/like/' . $product->id);
        $response->assertStatus(302);
        $response = $this->get('/item/' . $product->id);
        $response->assertStatus(200);

        // いいね数が0に減少していることを確認
        $response->assertSee('<p class="item-detail__action-count">0</p>', false);
    }

}
