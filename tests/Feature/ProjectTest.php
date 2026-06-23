<?php

namespace Tests\Feature;

use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_index_page_is_accessible(): void
    {
        $response = $this->get(route('projects.index'));

        $response->assertOk();
    }

    public function test_authenticated_owner_can_update_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('projects.update', $project), [
            'name' => 'Updated Project',
            'description' => 'Updated description',
        ]);

        $response->assertRedirect(route('projects.show', $project));
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Updated Project',
        ]);
    }

    public function test_guest_cannot_update_someone_elses_project(): void
    {
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);

        $response = $this->put(route('projects.update', $project), [
            'name' => 'Hacked',
            'description' => 'Nope',
        ]);

        $response->assertForbidden();
    }

    public function test_project_show_displays_issues(): void
    {
        $project = Project::factory()->create();
        Issue::factory()->count(2)->create(['project_id' => $project->id]);

        $response = $this->get(route('projects.show', $project));

        $response->assertOk();
        $response->assertSee($project->name);
    }
}
