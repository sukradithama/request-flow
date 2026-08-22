<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'category' => 'Equipment',
            'slug' => 'equipment',
            'is_active' => true,
        ]);

        Category::create([
            'category' => 'Software',
            'slug' => 'software',
            'is_active' => true,
        ]);

        Category::create([
            'category' => 'Network',
            'slug' => 'network',
            'is_active' => true,
        ]);

        Category::create([
            'category' => 'Office',
            'slug' => 'office',
            'is_active' => true,
        ]);
    }
}
