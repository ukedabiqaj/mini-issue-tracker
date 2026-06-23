<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Issue::query()->each(function (Issue $issue): void {
            Comment::factory()
                ->count(fake()->numberBetween(1, 5))
                ->create(['issue_id' => $issue->id]);
        });
    }
}
