<?php

namespace App\Transformers;

use App\constants\ArticleSources;
use App\Transformers\NewsTransformerInterface;

class NYTTransformer implements NewsTransformerInterface
{

    public function transform(array $raw): array
    {
        $publishedAt = !empty($raw['pub_date']) ? date('Y-m-d H:i:s', strtotime($raw['pub_date']))
            : now()->toDateTime()->format('Y-m-d H:i:s');

        return [
            'title' => $raw['headline']['main'] ?? '',
            'content' => $raw['abstract'] ?? '',
            'category' => $raw['section_name'] ?? 'general',
            'source' => ArticleSources::NEW_YORK_SOURCE,
            'published_at' => $publishedAt,
            'authors' => $this->extractAuthors($raw),
        ];
    }

    private function extractAuthors(array $raw): array
    {
        // NYT typically includes "byline" like: "By Jane Doe and John Smith"
        $byline = $raw['byline']['original'] ?? '';
        if (preg_match('/by (.+)/i', strtolower($byline), $matches)) {
            return array_map('trim', preg_split('/ and |, /i', ucwords($matches[1])));
        }

        return [];
    }
}
