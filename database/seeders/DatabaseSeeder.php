<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Warehouse::insert([
            'name' => 'Склад 1'
        ], [
            'name' => 'Склад 2'
        ], [
            'name' => 'Склад 3'
        ]);


        Product::insert([
            'name' => 'Товар 1',
            'article' => 'tovar1',
            'price' => 10.5
        ], [
            'name' => 'Товар 2',
            'article' => 'tovar2',
            'price' => 11.2
        ]);
    }
}
