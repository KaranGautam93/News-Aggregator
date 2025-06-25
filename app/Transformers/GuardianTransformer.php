<?php

namespace App\Transformers;

use App\Transformers\NewsTransformerInterface;

class GuardianTransformer implements NewsTransformerInterface
{

    public function transform(array $raw): array
    {
        return [
            'title' => $raw['webTitle'] ?? '',
            'content' => $raw['fields']['body'] ?? '',
            'category' => $raw['sectionName'] ?? 'general',
            'source' => 'The Guardian',
            'published_at' => $raw['webPublicationDate'] ?? now()->toDateTimeString(),
        ];
    }
}
