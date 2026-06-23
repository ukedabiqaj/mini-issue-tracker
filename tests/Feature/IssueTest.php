<?php

namespace Tests\Feature;

use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IssueTest extends TestCase
{
    use RefreshDatabase;

    public function test_issues_can_be_filtered_by_status_priority_and_tag(): void
    {
        $project = Project::factory()->create();
        $tag = Tag::factory()->create();

        $matchingIssue = Issue::factory()->create([
            'project_id' => $project->id,
            'status' => 'open',
            'priority' => 'high',
            'title' => 'Matching issue',
        ]);
        $matchingIssue->tags()->attach($tag);

        Issue::factory()->create([
            'project_id' => $project->id,
            'status' => 'closed',
            'priority' => 'low',
            'title' => 'Other issue',
        ]);

        $response = $this->get(route('issues.index', [
            'status' => 'open',
            'priority' => 'high',
            'tag' => $tag->id,
        ]));

        $response->assertOk();
        $response->assertSee('Matching issue');
        $response->assertDontSee('Other issue');
    }

    public function test_issue_search_returns_matching_results(): void
    {
        $project = Project::factory()->create();
        Issue::factory()->create([
            'project_id' => $project->id,
            'title' => 'Unique searchable title',
            'description' => 'Nothing special',
        ]);

        $response = $this->getJson(route('issues.search', ['q' => 'Unique searchable']));

        $response->assertOk();
        $response->assertJsonFragment(['title' => 'Unique searchable title']);
    }

    public function test_issue_search_returns_empty_array_for_blank_query(): void
    {
        $response = $this->getJson(route('issues.search'));

        $response->assertOk();
        $response->assertExactJson([]);
    }
}
