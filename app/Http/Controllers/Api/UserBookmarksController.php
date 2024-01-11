<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Bookmarks\IndexBookmarksRequest;
use App\Http\Resources\BookmarkResource;
use App\Models\User;

class UserBookmarksController
{
    public function index(User $user, IndexBookmarksRequest $request)
    {
        $bookmarks = $user
            ->bookmarks()
            ->when($request->search, fn ($q) => $q->where('name', 'like', "{$request->search}%"))
            ->orderBy('last_used_at', 'desc')
            ->get();

        return BookmarkResource::collection($bookmarks);
    }
}
