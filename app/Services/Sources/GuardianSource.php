<?php

namespace App\Services\Sources;

use App\Services\Sources\SourceInterface;
use Illuminate\Support\Facades\Http;

class GuardianSource implements SourceInterface
{

    const BASE_URL = 'https://content.guardianapis.com';

    public function fetch(): array
    {
        $res = Http::get(self::BASE_URL . '/search?api-key=' . config('news.guardian.key') . '&show-fields=all');

        return collect($res->json()['response']['results'] ?? [])
            ->map(function ($item) {
                return [
                    'title' => $item['webTitle'],
                    'content' => $item['fields']['body'] ?? '',
                    'category' => $item['sectionName'] ?? 'general',
                    'source' => 'The Guardian',
                    'published_at' => $item['webPublicationDate'],
                ];
            })->toArray();
    }
}
