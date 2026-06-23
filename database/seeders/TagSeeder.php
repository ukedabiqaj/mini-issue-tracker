<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'bug', 'color' => '#ef4444'],
            ['name' => 'feature', 'color' => '#22c55e'],
            ['name' => 'urgent', 'color' => '#f97316'],
            ['name' => 'documentation', 'color' => '#3b82f6'],
            ['name' => 'enhancement', 'color' => '#8b5cf6'],
            ['name' => 'backend', 'color' => '#06b6d4'],
            ['name' => 'frontend', 'color' => '#ec4899'],
            ['name' => 'design', 'color' => '#eab308'],
            ['name' => 'testing', 'color' => '#64748b'],
            ['name' => 'refactor', 'color' => '#14b8a6'],
        ];

        foreach ($tags as $tag) {
            Tag::query()->firstOrCreate(
                ['name' => $tag['name']],
                ['color' => $tag['color']],
            );
        }
    }
}
