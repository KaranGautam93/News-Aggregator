<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class UserPreference extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'user_preferences';

    protected $fillable = [
        'user_id',
        'preferred_sources',
        'preferred_categories',
        'preferred_authors',
    ];

    protected $casts = [
        'preferred_sources' => 'array',
        'preferred_categories' => 'array',
        'preferred_authors' => 'array',
    ];
}
