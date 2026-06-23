<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_comments_can_be_loaded_via_ajax(): void
    {
        $issue = Issue::factory()->for(Project::factory())->create();
        Comment::factory()->count(3)->create(['issue_id' => $issue->id]);

        $response = $this->getJson(route('issues.comments.index', $issue));

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
    }

    public function test_comment_creation_requires_valid_fields(): void
    {
        $issue = Issue::factory()->for(Project::factory())->create();

        $response = $this->postJson(route('issues.comments.store', $issue), []);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['author_name', 'body']);
    }

    public function test_comment_can_be_created_via_ajax(): void
    {
        $issue = Issue::factory()->for(Project::factory())->create();

        $response = $this->postJson(route('issues.comments.store', $issue), [
            'author_name' => 'Alice',
            'body' => 'This is a test comment.',
        ]);

        $response->assertCreated();
        $response->assertJsonFragment([
            'author_name' => 'Alice',
            'body' => 'This is a test comment.',
        ]);
        $this->assertDatabaseHas('comments', [
            'issue_id' => $issue->id,
            'author_name' => 'Alice',
        ]);
    }
}
