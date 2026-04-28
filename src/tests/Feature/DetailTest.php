<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;

class DetailTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // カテゴリを複数設定した場合、商品詳細画面でカテゴリが正しく表示するか確認
    public function test_product_detail_page_displays_related_categories()
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
            'price' => 10000,
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        // カテゴリーを作成
        $categoryFashion = Category::create([
            'name' => 'ファッション',
        ]);

        $categoryMens = Category::create([
            'name' => 'メンズ',
        ]);

        Category::create([
            'name' => 'ゲーム',
        ]);

        // 商品にカテゴリーを設定する
        $product->categories()->attach($categoryFashion->id);
        $product->categories()->attach($categoryMens->id);

        // ログイン用ユーザーでログイン
        $response = $this->from('/login')->post('/login',[
            'email' => 'user@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();

        // 商品ページへ遷移する
        $response = $this->get('/item/' . $product->id);
        $response->assertStatus(200);

        // カテゴリが複数表示されていることを確認する
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
        $response->assertDontSee('ゲーム');
    }

    // 商品詳細が表示されるか確認
    public function test_product_detail_page_displays_all_required_information()
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

        $commentUser = User::factory()->create([
            'name' => 'コメントユーザー',
            'email' => 'user_comment@test.com',
            'password' => bcrypt('password123'),
        ]);

        // 商品を作成
        $product = Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => '腕時計',
            'brand' => 'Rolex',
            'description' => '高級時計です',
            'price' => 10000,
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        // カテゴリーを作成
        $category = Category::create([
            'name' => 'ファッション',
        ]);

        // 商品にカテゴリーを設定する
        $product->categories()->attach($category->id);

        // コメントを作成
        Comment::create([
            'product_id' => $product->id,
            'user_id' => $commentUser->id,
            'content' => 'とても良い商品です',
        ]);

        // ログイン用ユーザーでログイン
        $response = $this->from('/login')->post('/login',[
            'email' => 'user@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();

        // 腕時計をいいねする
        $response = $this->post('/like/' . $product->id);
        $response->assertStatus(302);

        // 商品ページへ遷移する
        $response = $this->get('/item/' . $product->id);
        $response->assertStatus(200);

        // 商品情報が表示されているか確認
        $response->assertSee('腕時計');
        $response->assertSee('Rolex');
        $response->assertSee('10,000');
        $response->assertSee('高級時計です');
        $response->assertSee('ファッション');
        $response->assertSee('良好');

        // いいね数・コメント数
       $response->assertSee('1');

       // コメント情報
        $response->assertSee('コメントユーザー');
        $response->assertSee('とても良い商品です');

        // 画像パス確認
        $response->assertSee('test.jpg');
    }
}
