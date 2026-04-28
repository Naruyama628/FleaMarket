<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Profile;

class SellMethodTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_required_product_information_is_saved_when_listing_item()
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

        $category1 = Category::create([
            'name' => 'ファッション',
        ]);

        $category2 = Category::create([
            'name' => 'メンズ',
        ]);

        $file = UploadedFile::fake()->create('watch.jpg', 100, 'image/jpeg');
        $response = $this->post('/sell', [
            'name' => '腕時計',
            'brand' => 'Rolex',
            'description' => '高級時計です',
            'price' => 20000,
            'condition' => '良好',
            'category' => [$category1->id, $category2->id],
            'image' => $file,
        ]);
        $response->assertStatus(302);

        $this->assertDatabaseHas('products', [
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolex',
            'description' => '高級時計です',
            'price' => 20000,
            'condition' => '良好',
        ]);

        $product = Product::where('name', '腕時計')->first();

        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => $category1->id,
        ]);

        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => $category2->id,
        ]);
    }
}
