<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Supplier::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $suppliers = array (
  0 => 
  array (
    'id' => 1,
    'brand' => 'Pop Mart',
    'contact_person' => 'Feonna Calupas',
    'email' => 'popmart.supplier@gmail.com',
    'phone' => '0912-573-5462',
    'address' => 'Makati City',
  ),
  1 => 
  array (
    'id' => 2,
    'brand' => 'Funko',
    'contact_person' => 'Nhaj Bravo',
    'email' => 'funko.supplier@gmail.com',
    'phone' => '0912-573-5463',
    'address' => 'Marikina City',
  ),
);

        foreach ($suppliers as $supplierData) {
            unset($supplierData['id']);
            Supplier::create($supplierData);
        }
    }
}
