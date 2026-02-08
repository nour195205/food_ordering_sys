<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BurgerMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. إضافة التصنيفات الأساسية
        $bestSelling = Category::create(['name' => 'Best Selling', 'slug' => 'best-selling']);
        $extra = Category::create(['name' => 'Extra', 'slug' => 'extra']);

        // 2. إضافة منتجات قسم Best Selling مع الـ Variants بتاعتها
        $products = [
            [
                'name' => 'Cheese Burger',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 110],
                    ['variant_name' => 'Chunky', 'price' => 195],
                    ['variant_name' => 'Chicken', 'price' => 100],
                ]
            ],
            [
                'name' => 'The Rocket',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 130],
                    ['variant_name' => 'Chunky', 'price' => 220],
                    ['variant_name' => 'Chicken', 'price' => 120],
                ]
            ],
            [
                'name' => 'Back Fire',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 110],
                    ['variant_name' => 'Chunky', 'price' => 195],
                    ['variant_name' => 'Chicken', 'price' => 100],
                ]
            ],
            [
                'name' => 'Stock Yards',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 120],
                    ['variant_name' => 'Chunky', 'price' => 200],
                    ['variant_name' => 'Chicken', 'price' => 110],
                ]
            ],
            [
                'name' => 'Red Ghost',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 120],
                    ['variant_name' => 'Chunky', 'price' => 200],
                ]
            ],
            [
                'name' => 'Anti Burger',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 160],
                    ['variant_name' => 'Chunky', 'price' => 240],
                ]
            ],
        ];

        foreach ($products as $pData) {
            $product = Product::create([
                'category_id' => $bestSelling->id,
                'name' => $pData['name'],
                'image' => strtolower(str_replace(' ', '-', $pData['name'])) . '.jpg', // اسم افتراضي للصورة
            ]);

            foreach ($pData['variants'] as $variant) {
                $product->variants()->create($variant);
            }
        }

        // 3. إضافة الإضافات (Extras) كمنتجات بـ Variant واحد
        $extras = [
            ['name' => 'Crispy Chicken', 'price' => 90],
            ['name' => 'Beef Patty (Small)', 'price' => 90],
            ['name' => 'Beef Patty (Large)', 'price' => 170],
            ['name' => 'Beacon', 'price' => 20],
        ];

        foreach ($extras as $e) {
            $product = Product::create([
                'category_id' => $extra->id,
                'name' => $e['name'],
                'image' => 'extra.jpg',
            ]);
            
            $product->variants()->create([
                'variant_name' => 'Regular',
                'price' => $e['price']
            ]);
        }
    }
}
