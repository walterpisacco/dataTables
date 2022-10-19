<?php

namespace Database\Seeders;
use App\Models\Product;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Azucar','description' => 'blanca', 'price' => '120', 'cant' => '12'],
            ['name' => 'Sal','description' => 'gruesa', 'price' => '230', 'cant' => '6'],
            ['name' => 'Pan','description' => 'frances', 'price' => '1244', 'cant' => '5'],
            ['name' => 'Aceite','description' => 'girasol', 'price' => '344', 'cant' => '20'],
        ];

        Product::factory()->createMany($data);
    }
}
