<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $user = User::factory()->create();

        // 腕時計
        $sourcePath = public_path('img/Armani+Mens+Clock.jpg');
        $destinationPath = 'products/image1.jpg';

        Storage::disk('public')->put(
            $destinationPath,
            file_get_contents($sourcePath)
        );

        Product::create([
            'user_id' => $user->id,
            'name' => '腕時計',
            'price' => 15000,
            'brand' => 'Rolex',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image' => $destinationPath,
            'condition' => '良好',
        ]);

        // HDD
        $sourcePath = public_path('img/HDD+Hard+Disk.jpg');
        $destinationPath = 'products/image2.jpg';

        Storage::disk('public')->put(
            $destinationPath,
            file_get_contents($sourcePath)
        );

        Product::create([
            'user_id' => $user->id,
            'name' => 'HDD',
            'price' => 5000,
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image' => $destinationPath,
            'condition' => '目立った傷や汚れなし',
        ]);

        // 玉ねぎ3束
        $sourcePath = public_path('img/iLoveIMG+d.jpg');
        $destinationPath = 'products/image3.jpg';

        Storage::disk('public')->put(
            $destinationPath,
            file_get_contents($sourcePath)
        );

        Product::create([
            'user_id' => $user->id,
            'name' => '玉ねぎ3束',
            'price' => 300,
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'image' => $destinationPath,
            'condition' => 'やや傷や汚れあり',
        ]);

        // 革靴
        $sourcePath = public_path('img/Leather+Shoes+Product+Photo.jpg');
        $destinationPath = 'products/image4.jpg';

        Storage::disk('public')->put(
            $destinationPath,
            file_get_contents($sourcePath)
        );

        Product::create([
            'user_id' => $user->id,
            'name' => '革靴',
            'price' => 4000,
            'brand' => '',
            'description' => 'クラシックなデザインの革靴',
            'image' => $destinationPath,
            'condition' => '状態が悪い',
        ]);

        // ノートPC
        $sourcePath = public_path('img/Living+Room+Laptop.jpg');
        $destinationPath = 'products/image5.jpg';

        Storage::disk('public')->put(
            $destinationPath,
            file_get_contents($sourcePath)
        );

        Product::create([
            'user_id' => $user->id,
            'name' => 'ノートPC',
            'price' => 45000,
            'brand' => '',
            'description' => '高性能なノートパソコン',
            'image' => $destinationPath,
            'condition' => '良好',
        ]);

        // マイク
        $sourcePath = public_path('img/Music+Mic+4632231.jpg');
        $destinationPath = 'products/image6.jpg';

        Storage::disk('public')->put(
            $destinationPath,
            file_get_contents($sourcePath)
        );

        Product::create([
            'user_id' => $user->id,
            'name' => 'マイク',
            'price' => 8000,
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'image' => $destinationPath,
            'condition' => '目立った傷や汚れなし',
        ]);
        
        // ショルダーバッグ
        $sourcePath = public_path('img/Purse+fashion+pocket.jpg');
        $destinationPath = 'products/image7.jpg';

        Storage::disk('public')->put(
            $destinationPath,
            file_get_contents($sourcePath)
        );

        Product::create([
            'user_id' => $user->id,
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'brand' => '',
            'description' => 'おしゃれなショルダーバッグ',
            'image' => $destinationPath,
            'condition' => 'やや傷や汚れあり',
        ]);

        // タンブラー
        $sourcePath = public_path('img/Tumbler+souvenir.jpg');
        $destinationPath = 'products/image8.jpg';

        Storage::disk('public')->put(
            $destinationPath,
            file_get_contents($sourcePath)
        );

        Product::create([
            'user_id' => $user->id,
            'name' => 'タンブラー',
            'price' => 500,
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'image' => $destinationPath,
            'condition' => '状態が悪い',
        ]);

        // コーヒーミル
        $sourcePath = public_path('img/Waitress+with+Coffee+Grinder.jpg');
        $destinationPath = 'products/image9.jpg';

        Storage::disk('public')->put(
            $destinationPath,
            file_get_contents($sourcePath)
        );

        Product::create([
            'user_id' => $user->id,
            'name' => 'コーヒーミル',
            'price' => 4000,
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'image' => $destinationPath,
            'condition' => '良好',
        ]);

        // メイクセット
        $sourcePath = public_path('img/外出メイクアップセット.jpg');
        $destinationPath = 'products/image10.jpg';

        Storage::disk('public')->put(
            $destinationPath,
            file_get_contents($sourcePath)
        );

        Product::create([
            'user_id' => $user->id,
            'name' => 'メイクセット',
            'price' => 2500,
            'brand' => '',
            'description' => '便利なメイクアップセット',
            'image' => $destinationPath,
            'condition' => '目立った傷や汚れなし',
        ]);
    }
}