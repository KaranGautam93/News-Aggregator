<?php

namespace App\Repository;

use App\Models\UserPreference;

class UserPreferenceRepository
{
    public function getOrCreateUserPreferences($userId): ?UserPreference
    {
        return UserPreference::firstOrCreate([
            'user_id' => $userId
        ]);
    }

    public function getOrUpdateUserPreferences($request, $userId): ?UserPreference
    {
        return UserPreference::updateOrCreate(
            ['user_id' => $userId],
            $request
        );
    }

    public function getUserPreferences($userId)
    {
        return UserPreference::where('user_id', $userId)->first();
    }
}
