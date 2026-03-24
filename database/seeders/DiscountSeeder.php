<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Discount::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $discounts = array (
  0 => 
  array (
    'id' => 1,
    'code' => 'WELCOME10',
    'description' => '10% off for new customers!',
    'discount_type' => 'percentage',
    'discount_value' => '10.00',
    'min_purchase' => '500.00',
    'start_date' => '2026-03-24T00:00:00.000000Z',
    'end_date' => '2027-03-24T00:00:00.000000Z',
    'is_active' => true,
  ),
);

        foreach ($discounts as $discountData) {
            unset($discountData['id']);
            Discount::create($discountData);
        }
    }
}
