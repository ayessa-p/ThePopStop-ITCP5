<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        ProductPhoto::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $products = array (
  0 => 
  array (
    'id' => 1,
    'name' => 'Hirono × Stefanie Sun AUT NIHILO Figure',
    'series' => 'Hirono',
    'brand' => 'Pop Mart',
    'price' => '2550.00',
    'cost_price' => '2450.00',
    'sku' => 'PM-HIR-001',
    'description' => 'Hirono × Stefanie Sun AUT NIHILO Figure',
    'character' => NULL,
    'stock_quantity' => 15,
    'category' => 'Figurines',
    'type' => 'Limited Edition',
    'image_url' => 'products/hirono1.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 2,
        'product_id' => 1,
        'photo_url' => 'products/hirono1.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T14:54:11.000000Z',
        'updated_at' => '2026-03-17T16:47:04.000000Z',
      ),
      1 => 
      array (
        'id' => 5,
        'product_id' => 1,
        'photo_url' => 'products/hirono1.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T15:22:59.000000Z',
        'updated_at' => '2026-03-17T16:47:04.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/hirono1.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/hirono1.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  1 => 
  array (
    'id' => 2,
    'name' => 'Hirono × Stefanie Sun Weather With You Figurine',
    'series' => 'Hirono',
    'brand' => 'Pop Mart',
    'price' => '6000.00',
    'cost_price' => '5900.00',
    'sku' => 'PM-HIR-002',
    'description' => 'Hirono × Stefanie Sun Weather With You Figurine',
    'character' => NULL,
    'stock_quantity' => 18,
    'category' => 'Figurines',
    'type' => 'Limited Edition',
    'image_url' => 'products/hirono2.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 3,
        'product_id' => 2,
        'photo_url' => 'products/hirono2.1.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T14:54:11.000000Z',
        'updated_at' => '2026-03-17T14:54:11.000000Z',
      ),
      1 => 
      array (
        'id' => 4,
        'product_id' => 2,
        'photo_url' => 'products/hirono 2.2.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T14:54:11.000000Z',
        'updated_at' => '2026-03-17T14:54:11.000000Z',
      ),
      2 => 
      array (
        'id' => 6,
        'product_id' => 2,
        'photo_url' => 'products/hirono2.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T15:22:59.000000Z',
        'updated_at' => '2026-03-17T15:22:59.000000Z',
      ),
      3 => 
      array (
        'id' => 7,
        'product_id' => 2,
        'photo_url' => 'products/hirono 2.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T15:22:59.000000Z',
        'updated_at' => '2026-03-17T15:22:59.000000Z',
      ),
      4 => 
      array (
        'id' => 8,
        'product_id' => 2,
        'photo_url' => 'products/hirono2.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/hirono2.1.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/hirono 2.2.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
      2 => 
      array (
        'photo_url' => 'products/hirono2.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      3 => 
      array (
        'photo_url' => 'products/hirono 2.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
      4 => 
      array (
        'photo_url' => 'products/hirono2.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  2 => 
  array (
    'id' => 3,
    'name' => 'Hirono Birdy Figurine',
    'series' => 'Hirono',
    'brand' => 'Pop Mart',
    'price' => '6000.00',
    'cost_price' => '5900.00',
    'sku' => 'PM-HIR-003',
    'description' => 'Hirono Birdy Figurine',
    'character' => NULL,
    'stock_quantity' => 10,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/hirono3.jpg',
    'status' => 'Low Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 9,
        'product_id' => 3,
        'photo_url' => 'products/hirono3.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 10,
        'product_id' => 3,
        'photo_url' => 'products/hirono3.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/hirono3.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/hirono3.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  3 => 
  array (
    'id' => 4,
    'name' => 'Hirono Reshape Figurine',
    'series' => 'Hirono',
    'brand' => 'Pop Mart',
    'price' => '6000.00',
    'cost_price' => '5900.00',
    'sku' => 'PM-HIR-004',
    'description' => 'Hirono Reshape Figurine',
    'character' => NULL,
    'stock_quantity' => 12,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/hirono4.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 11,
        'product_id' => 4,
        'photo_url' => 'products/hirono4.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 12,
        'product_id' => 4,
        'photo_url' => 'products/hirono4.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/hirono4.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/hirono4.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  4 => 
  array (
    'id' => 5,
    'name' => 'Hirono x Keith Haring Figurine',
    'series' => 'Hirono',
    'brand' => 'Pop Mart',
    'price' => '6000.00',
    'cost_price' => '5900.00',
    'sku' => 'PM-HIR-005',
    'description' => 'Hirono x Keith Haring Figurine',
    'character' => NULL,
    'stock_quantity' => 7,
    'category' => 'Figurines',
    'type' => 'Limited Edition',
    'image_url' => 'products/hirono5.jpg',
    'status' => 'Low Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 13,
        'product_id' => 5,
        'photo_url' => 'products/hirono5.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 14,
        'product_id' => 5,
        'photo_url' => 'products/hirono5.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/hirono5.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/hirono5.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  5 => 
  array (
    'id' => 6,
    'name' => 'Hirono × Gary Baseman Figure',
    'series' => 'Hirono',
    'brand' => 'Pop Mart',
    'price' => '1700.00',
    'cost_price' => '1600.00',
    'sku' => 'PM-HIR-006',
    'description' => 'Hirono × Gary Baseman Figure',
    'character' => NULL,
    'stock_quantity' => 20,
    'category' => 'Figurines',
    'type' => 'Blind Box',
    'image_url' => 'products/hirono6.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 15,
        'product_id' => 6,
        'photo_url' => 'products/hirono6.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 16,
        'product_id' => 6,
        'photo_url' => 'products/hirono6.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/hirono6.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/hirono6.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  6 => 
  array (
    'id' => 7,
    'name' => 'Hirono The Pianist Figure',
    'series' => 'Hirono',
    'brand' => 'Pop Mart',
    'price' => '2550.00',
    'cost_price' => '2450.00',
    'sku' => 'PM-HIR-007',
    'description' => 'Hirono The Pianist Figure',
    'character' => NULL,
    'stock_quantity' => 18,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/hirono7.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 17,
        'product_id' => 7,
        'photo_url' => 'products/hirono7.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 18,
        'product_id' => 7,
        'photo_url' => 'products/hirono7.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/hirono7.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/hirono7.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  7 => 
  array (
    'id' => 8,
    'name' => 'Hirono Living Wild-Fight for Joy Plush Doll',
    'series' => 'Hirono',
    'brand' => 'Pop Mart',
    'price' => '1470.00',
    'cost_price' => '1370.00',
    'sku' => 'PM-HIR-008',
    'description' => 'Hirono Living Wild-Fight for Joy Plush Doll',
    'character' => NULL,
    'stock_quantity' => 25,
    'category' => 'Plush',
    'type' => 'Regular',
    'image_url' => 'products/hirono8.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 19,
        'product_id' => 8,
        'photo_url' => 'products/hirono8.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 20,
        'product_id' => 8,
        'photo_url' => 'products/hirono8.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/hirono8.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/hirono8.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  8 => 
  array (
    'id' => 9,
    'name' => 'Hirono × Snoopy Figure',
    'series' => 'Hirono',
    'brand' => 'Pop Mart',
    'price' => '1700.00',
    'cost_price' => '1600.00',
    'sku' => 'PM-HIR-009',
    'description' => 'Hirono × Snoopy Figure',
    'character' => NULL,
    'stock_quantity' => 22,
    'category' => 'Figurines',
    'type' => 'Blind Box',
    'image_url' => 'products/hirono9.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 21,
        'product_id' => 9,
        'photo_url' => 'products/hirono9.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 22,
        'product_id' => 9,
        'photo_url' => 'products/hirono9.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/hirono9.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/hirono9.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  9 => 
  array (
    'id' => 10,
    'name' => 'Hirono Doll Panda Figure',
    'series' => 'Hirono',
    'brand' => 'Pop Mart',
    'price' => '1700.00',
    'cost_price' => '1600.00',
    'sku' => 'PM-HIR-010',
    'description' => 'Hirono Doll Panda Figure',
    'character' => NULL,
    'stock_quantity' => 16,
    'category' => 'Figurines',
    'type' => 'Blind Box',
    'image_url' => 'products/hirono10.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 23,
        'product_id' => 10,
        'photo_url' => 'products/hirono10.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 24,
        'product_id' => 10,
        'photo_url' => 'products/hirono10.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/hirono10.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/hirono10.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  10 => 
  array (
    'id' => 11,
    'name' => 'SKULLPANDA Covenant of the White Moon Figure',
    'series' => 'Skullpanda',
    'brand' => 'Pop Mart',
    'price' => '1700.00',
    'cost_price' => '1600.00',
    'sku' => 'PM-SKP-001',
    'description' => 'SKULLPANDA Covenant of the White Moon Figure',
    'character' => NULL,
    'stock_quantity' => 20,
    'category' => 'Figurines',
    'type' => 'Blind Box',
    'image_url' => 'products/skullpanda1.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 25,
        'product_id' => 11,
        'photo_url' => 'products/skullpanda1.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 26,
        'product_id' => 11,
        'photo_url' => 'products/skullpanda1.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/skullpanda1.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/skullpanda1.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  11 => 
  array (
    'id' => 12,
    'name' => 'SKULLPANDA The Glimpse Figure',
    'series' => 'Skullpanda',
    'brand' => 'Pop Mart',
    'price' => '1700.00',
    'cost_price' => '1600.00',
    'sku' => 'PM-SKP-002',
    'description' => 'SKULLPANDA The Glimpse Figure',
    'character' => NULL,
    'stock_quantity' => 18,
    'category' => 'Figurines',
    'type' => 'Blind Box',
    'image_url' => 'products/skullpanda2.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 27,
        'product_id' => 12,
        'photo_url' => 'products/skullpanda2.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 28,
        'product_id' => 12,
        'photo_url' => 'products/skullpanda2.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/skullpanda2.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/skullpanda2.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  12 => 
  array (
    'id' => 13,
    'name' => 'SKULLPANDA Club Man Figurine',
    'series' => 'Skullpanda',
    'brand' => 'Pop Mart',
    'price' => '1700.00',
    'cost_price' => '1600.00',
    'sku' => 'PM-SKP-003',
    'description' => 'SKULLPANDA Club Man Figurine',
    'character' => NULL,
    'stock_quantity' => 15,
    'category' => 'Figurines',
    'type' => 'Blind Box',
    'image_url' => 'products/skullpanda3.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 29,
        'product_id' => 13,
        'photo_url' => 'products/skullpanda3.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 30,
        'product_id' => 13,
        'photo_url' => 'products/skullpanda3.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/skullpanda3.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/skullpanda3.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  13 => 
  array (
    'id' => 14,
    'name' => 'CRYBABY BE MINE FIGURINE',
    'series' => 'Crybaby',
    'brand' => 'Pop Mart',
    'price' => '7280.00',
    'cost_price' => '7180.00',
    'sku' => 'PM-CRY-001',
    'description' => 'CRYBABY BE MINE FIGURINE',
    'character' => NULL,
    'stock_quantity' => 5,
    'category' => 'Figurines',
    'type' => 'Limited Edition',
    'image_url' => 'products/crybaby1.jpg',
    'status' => 'Low Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 31,
        'product_id' => 14,
        'photo_url' => 'products/crybaby1.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 32,
        'product_id' => 14,
        'photo_url' => 'products/crybaby1.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/crybaby1.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/crybaby1.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  14 => 
  array (
    'id' => 15,
    'name' => 'CRYBABY MAKE ME FLOAT FIGURE',
    'series' => 'Crybaby',
    'brand' => 'Pop Mart',
    'price' => '1700.00',
    'cost_price' => '1600.00',
    'sku' => 'PM-CRY-002',
    'description' => 'CRYBABY MAKE ME FLOAT FIGURE',
    'character' => NULL,
    'stock_quantity' => 14,
    'category' => 'Figurines',
    'type' => 'Blind Box',
    'image_url' => 'products/crybaby2.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 33,
        'product_id' => 15,
        'photo_url' => 'products/crybaby2.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 34,
        'product_id' => 15,
        'photo_url' => 'products/crybaby2.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/crybaby2.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/crybaby2.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  15 => 
  array (
    'id' => 16,
    'name' => 'Crybaby Coconut Figure-Brown',
    'series' => 'Crybaby',
    'brand' => 'Pop Mart',
    'price' => '1700.00',
    'cost_price' => '1600.00',
    'sku' => 'PM-CRY-003',
    'description' => 'Crybaby Coconut Figure-Brown',
    'character' => NULL,
    'stock_quantity' => 12,
    'category' => 'Figurines',
    'type' => 'Blind Box',
    'image_url' => 'products/crybaby3.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 35,
        'product_id' => 16,
        'photo_url' => 'products/crybaby3.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 36,
        'product_id' => 16,
        'photo_url' => 'products/crybaby3.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/crybaby3.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/crybaby3.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  16 => 
  array (
    'id' => 17,
    'name' => 'Crybaby Coconut Figure-Green',
    'series' => 'Crybaby',
    'brand' => 'Pop Mart',
    'price' => '1700.00',
    'cost_price' => '1600.00',
    'sku' => 'PM-CRY-004',
    'description' => 'Crybaby Coconut Figure-Green',
    'character' => NULL,
    'stock_quantity' => 11,
    'category' => 'Figurines',
    'type' => 'Blind Box',
    'image_url' => 'products/crybaby4.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 37,
        'product_id' => 17,
        'photo_url' => 'products/crybaby4.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 38,
        'product_id' => 17,
        'photo_url' => 'products/crybaby4.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/crybaby4.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/crybaby4.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  17 => 
  array (
    'id' => 18,
    'name' => 'LABUBU Hip-hop Girl Figure',
    'series' => 'The Monster',
    'brand' => 'Pop Mart',
    'price' => '1700.00',
    'cost_price' => '1600.00',
    'sku' => 'PM-LAB-001',
    'description' => 'LABUBU Hip-hop Girl Figure',
    'character' => NULL,
    'stock_quantity' => 25,
    'category' => 'Figurines',
    'type' => 'Blind Box',
    'image_url' => 'products/labubu1.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 39,
        'product_id' => 18,
        'photo_url' => 'products/labubu1.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 40,
        'product_id' => 18,
        'photo_url' => 'products/labubu1.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/labubu1.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/labubu1.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  18 => 
  array (
    'id' => 19,
    'name' => 'LABUBU Superstar Dance Moves Figure',
    'series' => 'The Monster',
    'brand' => 'Pop Mart',
    'price' => '1700.00',
    'cost_price' => '1600.00',
    'sku' => 'PM-LAB-002',
    'description' => 'LABUBU Superstar Dance Moves Figure',
    'character' => NULL,
    'stock_quantity' => 22,
    'category' => 'Figurines',
    'type' => 'Blind Box',
    'image_url' => 'products/labubu2.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 41,
        'product_id' => 19,
        'photo_url' => 'products/labubu2.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 42,
        'product_id' => 19,
        'photo_url' => 'products/labubu2.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/labubu2.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/labubu2.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  19 => 
  array (
    'id' => 20,
    'name' => 'THE MONSTERS_How to Train Your Dragon Figurine',
    'series' => 'The Monster',
    'brand' => 'Pop Mart',
    'price' => '6000.00',
    'cost_price' => '5900.00',
    'sku' => 'PM-MON-001',
    'description' => 'THE MONSTERS_How to Train Your Dragon Figurine',
    'character' => NULL,
    'stock_quantity' => 6,
    'category' => 'Figurines',
    'type' => 'Limited Edition',
    'image_url' => 'products/labubu3.jpg',
    'status' => 'Low Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 43,
        'product_id' => 20,
        'photo_url' => 'products/labubu3.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 44,
        'product_id' => 20,
        'photo_url' => 'products/labubuy3.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/labubu3.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/labubuy3.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  20 => 
  array (
    'id' => 21,
    'name' => 'PINO JELLY Chocolate Cookie Figurine',
    'series' => 'Pino Jelly',
    'brand' => 'Pop Mart',
    'price' => '5000.00',
    'cost_price' => '4900.00',
    'sku' => 'PM-PIN-001',
    'description' => 'PINO JELLY Chocolate Cookie Figurine',
    'character' => NULL,
    'stock_quantity' => 10,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/pino1.jpg',
    'status' => 'Low Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 45,
        'product_id' => 21,
        'photo_url' => 'products/pino1.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
      1 => 
      array (
        'id' => 46,
        'product_id' => 21,
        'photo_url' => 'products/pino1.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:03.000000Z',
        'updated_at' => '2026-03-17T17:07:03.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/pino1.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/pino1.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  21 => 
  array (
    'id' => 22,
    'name' => 'PINO JELLY Birthday Bash Figurine',
    'series' => 'Pino Jelly',
    'brand' => 'Pop Mart',
    'price' => '5000.00',
    'cost_price' => '4900.00',
    'sku' => 'PM-PIN-002',
    'description' => 'PINO JELLY Birthday Bash Figurine',
    'character' => NULL,
    'stock_quantity' => 12,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/pino2.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 47,
        'product_id' => 22,
        'photo_url' => 'products/pino2.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:04.000000Z',
        'updated_at' => '2026-03-17T17:07:04.000000Z',
      ),
      1 => 
      array (
        'id' => 48,
        'product_id' => 22,
        'photo_url' => 'products/pino2.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:04.000000Z',
        'updated_at' => '2026-03-17T17:07:04.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/pino2.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/pino2.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  22 => 
  array (
    'id' => 23,
    'name' => 'PINO JELLY Guess Who I am Figure',
    'series' => 'Pino Jelly',
    'brand' => 'Pop Mart',
    'price' => '1700.00',
    'cost_price' => '1600.00',
    'sku' => 'PM-PIN-003',
    'description' => 'PINO JELLY Guess Who I am Figure',
    'character' => NULL,
    'stock_quantity' => 18,
    'category' => 'Figurines',
    'type' => 'Blind Box',
    'image_url' => 'products/pino3.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 49,
        'product_id' => 23,
        'photo_url' => 'products/pino3.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:04.000000Z',
        'updated_at' => '2026-03-17T17:07:04.000000Z',
      ),
      1 => 
      array (
        'id' => 50,
        'product_id' => 23,
        'photo_url' => 'products/pino3.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:04.000000Z',
        'updated_at' => '2026-03-17T17:07:04.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/pino3.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/pino3.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  23 => 
  array (
    'id' => 24,
    'name' => 'PINO JELLY Fairyland Figurine',
    'series' => 'Pino Jelly',
    'brand' => 'Pop Mart',
    'price' => '5000.00',
    'cost_price' => '4900.00',
    'sku' => 'PM-PIN-004',
    'description' => 'PINO JELLY Fairyland Figurine',
    'character' => NULL,
    'stock_quantity' => 9,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/pino4.jpg',
    'status' => 'Low Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 51,
        'product_id' => 24,
        'photo_url' => 'products/pino4.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:04.000000Z',
        'updated_at' => '2026-03-17T17:07:04.000000Z',
      ),
      1 => 
      array (
        'id' => 52,
        'product_id' => 24,
        'photo_url' => 'products/pino4.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
        'created_at' => '2026-03-17T17:07:04.000000Z',
        'updated_at' => '2026-03-17T17:07:04.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/pino4.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
      1 => 
      array (
        'photo_url' => 'products/pino4.3.jpg',
        'is_primary' => false,
        'display_order' => 2,
      ),
    ),
  ),
  24 => 
  array (
    'id' => 25,
    'name' => 'Funko Marvel: Deadpool & Wolverine - Wolverine Pop! Vinyl Figure',
    'series' => 'Marvel',
    'brand' => 'Funko',
    'price' => '695.00',
    'cost_price' => '595.00',
    'sku' => 'FK-MAR-001',
    'description' => 'Funko Marvel: Deadpool & Wolverine - Wolverine Pop! Vinyl Figure',
    'character' => NULL,
    'stock_quantity' => 29,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/funko1.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 53,
        'product_id' => 25,
        'photo_url' => 'products/funko1.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:04.000000Z',
        'updated_at' => '2026-03-17T17:07:04.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/funko1.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
    ),
  ),
  25 => 
  array (
    'id' => 26,
    'name' => 'Funko Marvel: Deadpool & Wolverine - Deadpool Pop! Vinyl Figure',
    'series' => 'Marvel',
    'brand' => 'Funko',
    'price' => '695.00',
    'cost_price' => '595.00',
    'sku' => 'FK-MAR-002',
    'description' => 'Funko Marvel: Deadpool & Wolverine - Deadpool Pop! Vinyl Figure',
    'character' => NULL,
    'stock_quantity' => 28,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/funko2.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 55,
        'product_id' => 26,
        'photo_url' => 'products/funko2.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:04.000000Z',
        'updated_at' => '2026-03-17T17:07:04.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/funko2.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
    ),
  ),
  26 => 
  array (
    'id' => 27,
    'name' => 'Funko DC Comics Batman War Zone - The Joker War Joker Pop! Vinyl Figure',
    'series' => 'DC Comics',
    'brand' => 'Funko',
    'price' => '695.00',
    'cost_price' => '595.00',
    'sku' => 'FK-DC-001',
    'description' => 'Funko DC Comics Batman War Zone - The Joker War Joker Pop! Vinyl Figure',
    'character' => NULL,
    'stock_quantity' => 25,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/funko3.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
    ),
    'photos' => 
    array (
    ),
  ),
  27 => 
  array (
    'id' => 28,
    'name' => 'Funko Bleach Ichigo Kurosaki (FB Shikai) Funko Pop! Vinyl Figure',
    'series' => 'Anime',
    'brand' => 'Funko',
    'price' => '695.00',
    'cost_price' => '595.00',
    'sku' => 'FK-ANI-001',
    'description' => 'Funko Bleach Ichigo Kurosaki (FB Shikai) Funko Pop! Vinyl Figure',
    'character' => NULL,
    'stock_quantity' => 20,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/funko4.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
    ),
    'photos' => 
    array (
    ),
  ),
  28 => 
  array (
    'id' => 29,
    'name' => 'Funko Boruto: Naruto Next Generations Mirai Sarutobi Funko Pop! Vinyl Figure',
    'series' => 'Anime',
    'brand' => 'Funko',
    'price' => '695.00',
    'cost_price' => '595.00',
    'sku' => 'FK-ANI-002',
    'description' => 'Funko Boruto: Naruto Next Generations Mirai Sarutobi Funko Pop! Vinyl Figure',
    'character' => NULL,
    'stock_quantity' => 22,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/funko5.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
    ),
    'photos' => 
    array (
    ),
  ),
  29 => 
  array (
    'id' => 30,
    'name' => 'Funko Spider-Man 2 Game Miles Morales Upgraded Suit Funko Pop! Vinyl Figure',
    'series' => 'Games',
    'brand' => 'Funko',
    'price' => '695.00',
    'cost_price' => '595.00',
    'sku' => 'FK-GAM-001',
    'description' => 'Funko Spider-Man 2 Game Miles Morales Upgraded Suit Funko Pop! Vinyl Figure',
    'character' => NULL,
    'stock_quantity' => 18,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/funko6.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
    ),
    'photos' => 
    array (
    ),
  ),
  30 => 
  array (
    'id' => 31,
    'name' => 'Funko Demon Slayer Tengen Uzui Funko Pop! Vinyl Figure',
    'series' => 'Anime',
    'brand' => 'Funko',
    'price' => '695.00',
    'cost_price' => '595.00',
    'sku' => 'FK-ANI-003',
    'description' => 'Funko Demon Slayer Tengen Uzui Funko Pop! Vinyl Figure',
    'character' => NULL,
    'stock_quantity' => 24,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/funko7.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
    ),
    'photos' => 
    array (
    ),
  ),
  31 => 
  array (
    'id' => 32,
    'name' => 'Funko My Hero Academia Katsuki Bakugo Funko Pop! Vinyl Figure - Previews Exclusive',
    'series' => 'Anime',
    'brand' => 'Funko',
    'price' => '1195.00',
    'cost_price' => '1095.00',
    'sku' => 'FK-ANI-004',
    'description' => 'Funko My Hero Academia Katsuki Bakugo Funko Pop! Vinyl Figure - Previews Exclusive',
    'character' => NULL,
    'stock_quantity' => 12,
    'category' => 'Figurines',
    'type' => 'Limited Edition',
    'image_url' => 'products/funko8.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
      0 => 
      array (
        'id' => 67,
        'product_id' => 32,
        'photo_url' => 'products/funko8.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
        'created_at' => '2026-03-17T17:07:04.000000Z',
        'updated_at' => '2026-03-17T17:07:04.000000Z',
      ),
    ),
    'photos' => 
    array (
      0 => 
      array (
        'photo_url' => 'products/funko8.2.jpg',
        'is_primary' => false,
        'display_order' => 1,
      ),
    ),
  ),
  32 => 
  array (
    'id' => 33,
    'name' => 'Funko Black Clover Asta with Nero Funko Pop! Vinyl Figure',
    'series' => 'Anime',
    'brand' => 'Funko',
    'price' => '695.00',
    'cost_price' => '595.00',
    'sku' => 'FK-ANI-005',
    'description' => 'Funko Black Clover Asta with Nero Funko Pop! Vinyl Figure',
    'character' => NULL,
    'stock_quantity' => 19,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/funko9.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
    ),
    'photos' => 
    array (
    ),
  ),
  33 => 
  array (
    'id' => 34,
    'name' => 'Funko One Piece Onami (Wano) Funko Pop! Vinyl Figure',
    'series' => 'Anime',
    'brand' => 'Funko',
    'price' => '695.00',
    'cost_price' => '595.00',
    'sku' => 'FK-ANI-006',
    'description' => 'Funko One Piece Onami (Wano) Funko Pop! Vinyl Figure',
    'character' => NULL,
    'stock_quantity' => 21,
    'category' => 'Figurines',
    'type' => 'Regular',
    'image_url' => 'products/funko10.jpg',
    'status' => 'In Stock',
    'product_photos' => 
    array (
    ),
    'photos' => 
    array (
    ),
  ),
);

        foreach ($products as $productData) {
            $photos = $productData['photos'] ?? [];
            unset($productData['photos'], $productData['product_photos'], $productData['id']);
            
            $product = Product::create($productData);
            
            foreach ($photos as $photoData) {
                $product->productPhotos()->create($photoData);
            }
        }
    }
}
