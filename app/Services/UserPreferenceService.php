<?php

namespace App\Services;

use App\constants\ArticleSources;
use App\Models\UserPreference;
use App\Repository\UserPreferenceRepository;
use Illuminate\Support\Facades\Auth;

class UserPreferenceService
{
    public function __construct(protected UserPreferenceRepository $userPreferenceRepository)
    {
    }

    public function getUserPreference()
    {
        $prefs = $this->userPreferenceRepository->getOrCreateUserPreferences(Auth::id());

        if (!isset($prefs->preferred_sources)) {
            $prefs->preferred_sources = [];
            $prefs->preferred_categories = [];
            $prefs->preferred_authors = [];

            $prefs->save();
        }

        unset($prefs->updated_at, $prefs->created_at, $prefs->id);

        return $prefs;
    }

    public function updateUserPreference($request)
    {
        $prefs = $this->userPreferenceRepository->getOrUpdateUserPreferences($request, Auth::id());

        unset($prefs->updated_at, $prefs->created_at, $prefs->id);

        return $prefs;
    }

    public function isValidUserPreferenceRequest($request): bool
    {
        foreach ($request['preferred_sources'] as $source) {
            if (!in_array(strtolower($source), ArticleSources::VALID_SOURCES)) {
                return false;
            }
        }

        return true;
    }
}
