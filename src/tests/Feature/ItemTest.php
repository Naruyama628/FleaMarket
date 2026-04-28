<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class ItemTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // 全商品表示されているか
    public function test_all_products_are_displayed()
    {
        // ユーザーを作成
        User::factory()->create([
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

        // 商品一覧画面に遷移
        $response = $this->get('/');
        $response->assertStatus(200);

        // 作成した商品が表示されるか確認
        $response->assertSee('腕時計');
        $response->assertSee('置時計');
        $response->assertSee('clock');
    }

    // 購入済み商品にSoldラベルが表示されているか
    public function test_sold_label_is_displayed_for_sold_products()
    {
        // ユーザーを作成
        User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('password123'),
        ]);

        // 商品を作成し、購入済みにする
        Product::factory()->create([
            'user_id' => User::inRandomOrder()->first()->id,
            'name' => '置時計',
            'description' => 'two',
            'price' => 200,
            'image' => '',
            'is_sold' => true,
        ]);

        // 商品一覧画面に遷移
        $response = $this->get('/');
        $response->assertStatus(200);

        // 商品とSoldラベルが表示されることを確認
        $response->assertSee('置時計');
        $response->assertSee('Sold');
    }

    // 自分が出品している商品が表示されないか
    public function test_own_products_are_not_displayed()
    {
        // ユーザー1を作成
        $user_one = User::factory()->create([
            'email' => 'user_one@test.com',
            'password' => bcrypt('password123'),
        ]);

        // ユーザー2を作成
        $user_two = User::factory()->create([
            'email' => 'user_two@test.com',
            'password' => bcrypt('password123'),
        ]);

        // ユーザー1が出品した商品を2つ作成
        Product::factory()->create([
            'user_id' => $user_one->id,
            'name' => '腕時計',
            'description' => 'one',
            'price' => 100,
            'image' => '',
        ]);

        Product::factory()->create([
            'user_id' => $user_one->id,
            'name' => '置時計',
            'description' => 'two',
            'price' => 200,
            'image' => '',
        ]);

        // ユーザー2が出品した商品を1つ作成
        Product::factory()->create([
            'user_id' => $user_two->id,
            'name' => 'clock',
            'description' => 'three',
            'price' => 300,
            'image' => '',
        ]);

        // ユーザー1でログイン
        $response = $this->from('/login')->post('/login',[
            'email' => 'user_one@test.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();

        // 商品一覧画面に遷移
        $response = $this->get('/');
        $response->assertStatus(200);

        // ユーザー1が出品した商品は表示されず、ユーザー2が出品した商品が表示されることを確認
        $response->assertDontSee('腕時計');
        $response->assertDontSee('置時計');
        $response->assertSee('clock');
    }
}