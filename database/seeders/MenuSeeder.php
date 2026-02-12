<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Wipe existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductVariant::truncate();
        Product::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Define Categories
        $categories = [
            'beef' => Category::create(['name' => 'Beef Burger', 'slug' => 'beef-burger']),
            'chicken' => Category::create(['name' => 'Chicken Burger', 'slug' => 'chicken-burger']),
            'sides' => Category::create(['name' => 'Sides', 'slug' => 'sides']),
            'extras' => Category::create(['name' => 'Extras', 'slug' => 'extras']),
            'drinks' => Category::create(['name' => 'Drinks', 'slug' => 'drinks']),
        ];

        // 3. Define Products & Variants

        // --- Beef Burgers ---
        $beefBurgers = [
            [
                'name' => 'Cheese Burger',
                'description' => 'Classic beef burger with cheese',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 110],
                    ['variant_name' => 'Chunky', 'price' => 195],
                    ['variant_name' => 'Chicken', 'price' => 100],
                ]
            ],
            [
                'name' => 'The Rocket',
                'description' => 'Loaded with flavors',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 130],
                    ['variant_name' => 'Chunky', 'price' => 220],
                    ['variant_name' => 'Chicken', 'price' => 120],
                ]
            ],
            [
                'name' => 'Back Fire',
                'description' => 'Spicy kick',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 110],
                    ['variant_name' => 'Chunky', 'price' => 195],
                    ['variant_name' => 'Chicken', 'price' => 100],
                ]
            ],
            [
                'name' => 'Stock Yards',
                'description' => 'Rich and savory',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 120],
                    ['variant_name' => 'Chunky', 'price' => 200],
                    ['variant_name' => 'Chicken', 'price' => 110],
                ]
            ],
            [
                'name' => 'The MC Whopper',
                'description' => 'A classic reimagined',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 120],
                    ['variant_name' => 'Chunky', 'price' => 200],
                    ['variant_name' => 'Chicken', 'price' => 110],
                ]
            ],
            [
                'name' => 'Cheesy Mushroom',
                'description' => 'Topped with melted cheese and mushrooms',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 130],
                    ['variant_name' => 'Chunky', 'price' => 220],
                    ['variant_name' => 'Chicken', 'price' => 120],
                ]
            ],
            [
                'name' => 'Bamba Burger',
                'description' => 'Unique taste',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 110],
                    ['variant_name' => 'Chunky', 'price' => 195],
                    ['variant_name' => 'Chicken', 'price' => 100],
                ]
            ],
            [
                'name' => 'Red Ghost',
                'description' => 'Spicy ghost pepper sauce',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 120],
                    ['variant_name' => 'Chunky', 'price' => 200],
                ]
            ],
            [
                'name' => 'Tropica Burger',
                'description' => 'With pineapple slice',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 115],
                    ['variant_name' => 'Chunky', 'price' => 200],
                ]
            ],
            [
                'name' => 'Texas Burger',
                'description' => 'BBQ style',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 130],
                    ['variant_name' => 'Chunky', 'price' => 220],
                ]
            ],
            [
                'name' => 'Anti Burger',
                'description' => 'The anti-hero of burgers',
                'variants' => [
                    ['variant_name' => 'Single', 'price' => 160],
                    ['variant_name' => 'Chunky', 'price' => 240],
                ]
            ],
        ];

        foreach ($beefBurgers as $item) {
            $product = Product::create([
                'category_id' => $categories['beef']->id,
                'name' => $item['name'],
                'description' => $item['description'],
                'image' => 'default_burger.png',
                'is_active' => true,
            ]);

            foreach ($item['variants'] as $variant) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_name' => $variant['variant_name'],
                    'price' => $variant['price'],
                ]);
            }
        }

        // --- Chicken ---
        $chickenBurgers = [
            ['name' => 'Holy Chuck', 'price' => 110],
            ['name' => 'Crush Chicken', 'price' => 110],
            ['name' => 'Fire Bird', 'price' => 110],
        ];

        foreach ($chickenBurgers as $item) {
            $product = Product::create([
                'category_id' => $categories['chicken']->id,
                'name' => $item['name'],
                'description' => 'Delicious chicken burger',
                'image' => 'default_chicken.png',
                'is_active' => true,
            ]);
            
            // Standard variant for items without explicit size
            ProductVariant::create([
                'product_id' => $product->id,
                'variant_name' => 'Single',
                'price' => $item['price'],
            ]);
        }


        // --- Sides ---
        $sides = [
            ['name' => 'Fries', 'price' => 35],
            ['name' => 'Cheesy Fries', 'price' => 65],
            ['name' => 'Chilli Cheese Fries', 'price' => 75],
            ['name' => 'Wolf Fries', 'price' => 155],
            ['name' => 'Mushroom Frise', 'price' => 85],
            ['name' => 'Onion Ring', 'price' => 50],
            ['name' => 'Mozzarilla Sticks', 'price' => 50],
        ];

        foreach ($sides as $item) {
            $product = Product::create([
                'category_id' => $categories['sides']->id,
                'name' => $item['name'],
                'description' => '',
                'image' => 'default_side.png',
                'is_active' => true,
            ]);
             ProductVariant::create([
                'product_id' => $product->id,
                'variant_name' => 'Standard',
                'price' => $item['price'],
            ]);
        }

        // --- Extras ---
        $extras = [
            ['name' => 'Crispy Chicken', 'price' => 90],
            ['name' => 'Beef Patty', 'price' => 90], // Assuming 90 is the standard extra patty
            ['name' => 'Double Beef Patty', 'price' => 170], // The 170 option
            ['name' => 'Chicken', 'price' => 70],
            ['name' => 'Beacon', 'price' => 20],
            ['name' => 'Jalpeno', 'price' => 20],
            ['name' => 'Sauce', 'price' => 20],
            ['name' => 'Mushroom', 'price' => 25],
            ['name' => 'American Cheese', 'price' => 25],
            ['name' => 'Cheddar Cheese', 'price' => 30],
            ['name' => 'White Cheese', 'price' => 35],
            ['name' => 'Onion Ring (Extra)', 'price' => 20],
            ['name' => 'Mozzarilla Sticks (Extra)', 'price' => 20],
        ];

        foreach ($extras as $item) {
            $product = Product::create([
                'category_id' => $categories['extras']->id,
                'name' => $item['name'],
                'description' => 'Extra addition',
                'image' => 'default_extra.png',
                'is_active' => true,
            ]);
             ProductVariant::create([
                'product_id' => $product->id,
                'variant_name' => 'Standard',
                'price' => $item['price'],
            ]);
        }

        // --- Drinks ---
        $drinks = [
            ['name' => 'Cola', 'price' => 20],
            ['name' => 'Water', 'price' => 10],
        ];

        foreach ($drinks as $item) {
            $product = Product::create([
                'category_id' => $categories['drinks']->id,
                'name' => $item['name'],
                'description' => 'Refreshing drink',
                'image' => 'default_drink.png',
                'is_active' => true,
            ]);
             ProductVariant::create([
                'product_id' => $product->id,
                'variant_name' => 'Standard',
                'price' => $item['price'],
            ]);
        }
    }
}
