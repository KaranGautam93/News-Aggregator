<?php

namespace App\Services;

use App\constants\ArticleSources;
use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth;

class UserPreferenceService
{
    public function getUserPreference()
    {
        $prefs = UserPreference::firstOrCreate([
            'user_id' => Auth::id()
        ]);

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
        $prefs = UserPreference::updateOrCreate(
            ['user_id' => Auth::id()],
            $request
        );

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
