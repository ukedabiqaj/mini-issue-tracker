<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Issue;
use Illuminate\Http\JsonResponse;

class IssueCommentController extends Controller
{
    public function index(Issue $issue): JsonResponse
    {
        $comments = $issue->comments()
            ->latest()
            ->paginate(10);

        return response()->json($comments);
    }

    public function store(StoreCommentRequest $request, Issue $issue): JsonResponse
    {
        $comment = $issue->comments()->create($request->validated());

        return response()->json($comment, 201);
    }
}
