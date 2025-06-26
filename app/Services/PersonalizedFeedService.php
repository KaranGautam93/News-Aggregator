<?php

namespace App\Services;

use App\Models\Article;
use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth;

class PersonalizedFeedService
{
    public function generateFeed($perPage)
    {
        $userId = Auth::id();

        $prefs = UserPreference::where('user_id', $userId)->first();

        if (!$prefs) {
            return [
                'error' => 'No preferences found. Please set preferences first.'
            ];
        }

        $query = Article::query();

        if (!empty($prefs->preferred_sources)) {
            $query->whereIn('source', $prefs->preferred_sources);
        }

        if (!empty($prefs->preferred_categories)) {
            $query->whereIn('category', $prefs->preferred_categories);
        }

        if (!empty($prefs->preferred_authors)) {
            $query->whereJsonContains('authors', $prefs->preferred_authors);
        }

        return $query->latest('published_at')->select(['id', 'category', 'source', 'author', 'title', 'published_at'])->paginate($perPage);
    }
}
