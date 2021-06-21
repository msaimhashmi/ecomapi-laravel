<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(5)->create();
        \App\Models\Product::factory(50)->create();
        \App\Models\Review::factory(50)->create();
        // factory(App\Models\Product::class, 50)->create();
        // factory(App\Models\Review::class, 50)->create();
    }
}
