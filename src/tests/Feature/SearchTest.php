<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class SearchTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
  // 検索機能の確認
    public function test_search_results_are_displayed()
    {
        // ユーザーを作成
        $userSeller = User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('password123'),
        ]);

        // 商品を3つ作成
        Product::factory()->create([
            'user_id' => User::inRandomOrder()->first()->id,
            'name' => '腕時計',
            'description' => 'one',
            'price' => 100,
            'image' => '',
        ]);

        Product::factory()->create([
            'user_id' => User::inRandomOrder()->first()->id,
            'name' => '置時計',
            'description' => 'two',
            'price' => 200,
            'image' => '',
        ]);

        Product::factory()->create([
            'user_id' => User::inRandomOrder()->first()->id,
            'name' => 'clock',
            'description' => 'three',
            'price' => 300,
            'image' => '',
        ]);

        // 「時計」でキーワード検索
        $response = $this->get('/search?keyword=時計');
        $response->assertStatus(200);

        // 作成した商品が表示されるか確認
        $response->assertSee('腕時計');
        $response->assertSee('置時計');
        $response->assertDontSee('clock');
    }

    // 検索状態がマイリストでも保持されるか確認
    public function test_search_keyword_is_preserved_in_mylist()
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
        // 商品を3つ作成
        $watch = Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => '腕時計',
            'description' => 'one',
            'price' => 100,
            'image' => '',
        ]);

        Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => '置時計',
            'description' => 'two',
            'price' => 200,
            'image' => '',
        ]);

        $clock = Product::factory()->create([
            'user_id' => $userSeller->id,
            'name' => 'clock',
            'description' => 'three',
            'price' => 300,
            'image' => '',
        ]);

        // ログイン用ユーザーでログイン
        $response = $this->from('/login')->post('/login',[
            'email' => 'user@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();

        // 腕時計をいいねする
        $response = $this->post('/like/' . $watch->id);
        $response->assertStatus(302);

        // clockをいいねする
        $response = $this->post('/like/' . $clock->id);
        $response->assertStatus(302);

        // 「時計」でキーワード検索
        $response = $this->get('/search?keyword=時計');
        $response->assertStatus(200);

        // マイリストに遷移する
        $response = $this->get('/?tab=mylist&keyword=時計');
        $response->assertStatus(200);

        // いいねしてかつ、「時計」の検索ワードに引っかかる腕時計のみが表示されるか確認
        $response->assertSee('腕時計');
        $response->assertDontSee('置時計');
        $response->assertDontSee('clock');
    }
}
