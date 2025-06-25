<?php

return [
    'sources' => [
        App\Services\Sources\GuardianSource::class,
//        App\Services\Sources\NyTimesSource::class,
//        App\Services\Sources\BbcSource::class,
//        App\Services\Sources\NewsApiSource::class,
//        App\Services\Sources\NewsCredSource::class,
//        App\Services\Sources\OpenNewsSource::class,
    ],

    'guardian' => [
        'key' => env('GUARDIAN_API_KEY'),
    ],

    'newsapi' => [
        'key' => env('NEWSAPI_KEY'),
    ],

    'nytimes' => [
        'key' => env('NYTIMES_API_KEY'),
    ],
];
