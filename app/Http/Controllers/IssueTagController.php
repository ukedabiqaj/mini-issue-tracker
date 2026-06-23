<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class IssueTagController extends Controller
{
    public function store(Issue $issue, Tag $tag): JsonResponse
    {
        $issue->tags()->syncWithoutDetaching([$tag->id]);
        $issue->load('tags:id,name,color');

        return response()->json([
            'tags' => $issue->tags->sortBy('name')->values(),
        ]);
    }

    public function destroy(Issue $issue, Tag $tag): JsonResponse
    {
        $issue->tags()->detach($tag->id);
        $issue->load('tags:id,name,color');

        return response()->json([
            'tags' => $issue->tags->sortBy('name')->values(),
        ]);
    }
}
