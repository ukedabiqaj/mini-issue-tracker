<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class IssueUserController extends Controller
{
    public function store(Issue $issue, User $user): JsonResponse
    {
        $issue->users()->syncWithoutDetaching([$user->id]);
        $issue->load('users:id,name');

        return response()->json([
            'users' => $issue->users->sortBy('name')->values(),
        ]);
    }

    public function destroy(Issue $issue, User $user): JsonResponse
    {
        $issue->users()->detach($user->id);
        $issue->load('users:id,name');

        return response()->json([
            'users' => $issue->users->sortBy('name')->values(),
        ]);
    }
}
