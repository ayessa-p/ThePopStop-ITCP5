<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Order::truncate();
        OrderItem::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $orders = array (
  0 => 
  array (
    'id' => 1,
    'user_id' => 2,
    'discount_amount' => '189.00',
    'status' => 'Delivered',
    'shipping_address' => 'taguig',
    'payment_method' => 'Cash on Delivery',
    'order_items' => 
    array (
      0 => 
      array (
        'id' => 1,
        'order_id' => 1,
        'product_id' => 29,
        'quantity' => 1,
        'unit_price' => '695.00',
      ),
      1 => 
      array (
        'id' => 2,
        'order_id' => 1,
        'product_id' => 32,
        'quantity' => 1,
        'unit_price' => '1195.00',
      ),
    ),
    'items' => 
    array (
      0 => 
      array (
        'id' => 1,
        'order_id' => 1,
        'product_id' => 29,
        'quantity' => 1,
        'unit_price' => '695.00',
      ),
      1 => 
      array (
        'id' => 2,
        'order_id' => 1,
        'product_id' => 32,
        'quantity' => 1,
        'unit_price' => '1195.00',
      ),
    ),
  ),
);

        foreach ($orders as $orderData) {
            $items = $orderData['items'] ?? [];
            unset($orderData['items'], $orderData['order_items'], $orderData['id']);
            
            $order = Order::create($orderData);
            
            foreach ($items as $itemData) {
                unset($itemData['id'], $itemData['order_id']);
                $order->orderItems()->create($itemData);
            }
        }
    }
}
