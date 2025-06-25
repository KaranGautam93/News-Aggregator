<?php

namespace App\constants;

class ArticleSources
{
    const NEWS_API_SOURCE = 'news api';
    const NEW_YORK_SOURCE = 'the new york times';
    const THE_GUARDIAN_SOURCE = 'the guardian';

    const VALID_SOURCES = [
        self::NEWS_API_SOURCE,
        self::NEW_YORK_SOURCE,
        self::THE_GUARDIAN_SOURCE,
    ];
}
