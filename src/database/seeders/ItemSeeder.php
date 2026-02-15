<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            return;
        }

        $items = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'condition' => '良好',
                'image_path' => 'images/dummy/腕時計.jpg',
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'condition' => '目立った傷や汚れなし',
                'image_path' => 'images/dummy/HDD.jpg',
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand' => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'condition' => 'やや傷や汚れあり',
                'image_path' => 'images/dummy/玉ねぎ3束.jpg',
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'brand' => null,
                'description' => 'クラシックなデザインの革靴',
                'condition' => '状態が悪い',
                'image_path' => 'images/dummy/革靴.jpg',
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => null,
                'description' => '高性能なノートパソコン',
                'condition' => '良好',
                'image_path' => 'images/dummy/ノートPC.jpg',
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'brand' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'condition' => '目立った傷や汚れなし',
                'image_path' => 'images/dummy/マイク.jpg',
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'condition' => 'やや傷や汚れあり',
                'image_path' => 'images/dummy/ショルダーバッグ.jpg',
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => 'なし',
                'description' => '使いやすいタンブラー',
                'condition' => '状態が悪い',
                'image_path' => 'images/dummy/タンブラー.jpg',
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'condition' => '良好',
                'image_path' => 'images/dummy/コーヒーミル.jpg',
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => null,
                'description' => '便利なメイクアップセット',
                'condition' => '目立った傷や汚れなし',
                'image_path' => 'images/dummy/メイクセット.jpg',
            ],
        ];

        foreach ($items as $item) {
            Item::create([
                'user_id' => $user->id,
                'name' => $item['name'],
                'brand' => $item['brand'],
                'description' => $item['description'],
                'price' => $item['price'],
                'condition' => $item['condition'],
                'image_path' => $item['image_path'],
                'sold_flag' => false,
            ]);
        }
    }
}