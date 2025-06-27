<?php

namespace App\Services;

use App\Repository\ArticleRepository;
use App\Repository\UserPreferenceRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PersonalizedFeedService
{
    public function __construct(
        protected UserPreferenceRepository $userPreferenceRepository,
        protected ArticleRepository        $articleRepository)
    {
    }

    public function generateFeed($perPage)
    {
        $userId = Auth::id();

        $prefs = $this->userPreferenceRepository->getUserPreferences($userId);

        if (!$prefs) {
            return [
                'error' => 'No preferences found. Please set preferences first.'
            ];
        }

        $key = 'userfeed_' . $userId . "_" . md5(json_encode($prefs));

        $feed = Cache::tags(['userfeed'])->remember($key, now()->addMinutes(2), function () use ($prefs, $perPage) {
            return $this->articleRepository->getPreferredArticles($prefs, $perPage);
        });

        return $feed;
    }
}
