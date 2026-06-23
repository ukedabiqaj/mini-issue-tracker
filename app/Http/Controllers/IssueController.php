<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IssueController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'status' => ['nullable', Rule::in(['open', 'in_progress', 'closed'])],
            'priority' => ['nullable', Rule::in(['low', 'medium', 'high'])],
            'tag' => ['nullable', 'integer', 'exists:tags,id'],
        ]);

        $issues = Issue::query()
            ->with(['project', 'tags'])
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->status($status))
            ->when($filters['priority'] ?? null, fn ($query, $priority) => $query->priority($priority))
            ->when($filters['tag'] ?? null, fn ($query, $tagId) => $query->withTag((int) $tagId))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $tags = Tag::query()->orderBy('name')->get(['id', 'name']);

        return view('issues.index', compact('issues', 'tags'));
    }

    public function create(): View
    {
        $projects = Project::query()->orderBy('name')->get(['id', 'name']);

        return view('issues.create', compact('projects'));
    }

    public function store(StoreIssueRequest $request): RedirectResponse
    {
        $issue = Issue::query()->create($request->validated());

        return redirect()
            ->route('issues.show', $issue)
            ->with('success', 'Issue created successfully.');
    }

    public function show(Issue $issue): View
    {
        $issue->load([
            'project:id,name',
            'tags:id,name,color',
            'users:id,name',
        ]);

        $tags = Tag::query()->orderBy('name')->get(['id', 'name', 'color']);
        $users = User::query()->orderBy('name')->get(['id', 'name']);

        return view('issues.show', compact('issue', 'tags', 'users'));
    }

    public function edit(Issue $issue): View
    {
        $projects = Project::query()->orderBy('name')->get(['id', 'name']);

        return view('issues.edit', compact('issue', 'projects'));
    }

    public function update(UpdateIssueRequest $request, Issue $issue): RedirectResponse
    {
        $issue->update($request->validated());

        return redirect()
            ->route('issues.show', $issue)
            ->with('success', 'Issue updated successfully.');
    }

    public function destroy(Issue $issue): RedirectResponse
    {
        $issue->delete();

        return redirect()
            ->route('issues.index')
            ->with('success', 'Issue deleted successfully.');
    }

    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
        ]);

        $search = trim($validated['q'] ?? '');

        if ($search === '') {
            return response()->json([]);
        }

        $issues = Issue::query()
            ->with(['project:id,name', 'tags:id,name,color'])
            ->search($search)
            ->latest()
            ->limit(10)
            ->get();

        return response()->json($issues);
    }
}
