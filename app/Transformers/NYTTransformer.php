<?php

namespace App\Transformers;

use App\Transformers\NewsTransformerInterface;

class NYTTransformer implements NewsTransformerInterface
{

    public function transform(array $raw): array
    {
        return [
            'title'        => $raw['headline']['main'] ?? '',
            'content'      => $raw['abstract'] ?? '',
            'category'     => $raw['section_name'] ?? 'general',
            'source'       => 'The New York Times',
            'published_at' => $raw['pub_date'] ?? now()->toDateTimeString(),
        ];
    }
}
