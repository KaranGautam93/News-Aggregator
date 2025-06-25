<?php

return [
    'sources' => [
        App\Services\Sources\GuardianSource::class,
        App\Services\Sources\NewApiSource::class,
        App\Services\Sources\NYTSource::class,
    ],

    'guardian' => [
        'key' => env('GUARDIAN_API_KEY'),
    ],

    'newsapi' => [
        'key' => env('NEWSAPI_KEY'),
    ],

    'nytapi' => [
        'key' => env('NYT_API_KEY'),
    ],
];
