<?php

namespace Tests\Feature;

use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IssueTagApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_can_be_attached_and_detached_via_ajax(): void
    {
        $issue = Issue::factory()->for(Project::factory())->create();
        $tag = Tag::factory()->create();

        $attach = $this->postJson(route('issues.tags.store', [$issue, $tag]));
        $attach->assertOk();
        $attach->assertJsonFragment(['name' => $tag->name]);
        $this->assertTrue($issue->fresh()->tags->contains($tag));

        $detach = $this->deleteJson(route('issues.tags.destroy', [$issue, $tag]));
        $detach->assertOk();
        $this->assertFalse($issue->fresh()->tags->contains($tag));
    }
}
