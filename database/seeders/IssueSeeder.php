<?php

namespace Database\Seeders;

use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class IssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::all();
        $users = User::all();

        Project::query()->each(function (Project $project) use ($tags, $users): void {
            Issue::factory()
                ->count(5)
                ->create(['project_id' => $project->id])
                ->each(function (Issue $issue) use ($tags, $users): void {
                    if ($tags->isNotEmpty()) {
                        $selectedTags = $tags->random(fake()->numberBetween(1, min(3, $tags->count())));

                        $issue->tags()->attach(collect($selectedTags)->pluck('id'));
                    }

                    if ($users->isNotEmpty()) {
                        $selectedUsers = $users->random(fake()->numberBetween(1, min(2, $users->count())));

                        $issue->users()->attach(collect($selectedUsers)->pluck('id'));
                    }
                });
        });
    }
}
