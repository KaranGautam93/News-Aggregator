<?php

namespace App\Transformers;

use App\Transformers\NewsTransformerInterface;

class NYTTransformer implements NewsTransformerInterface
{

    public function transform(array $raw): array
    {
        $publishedAt = !empty($raw['pub_date']) ? date('Y-m-d H:i:s', strtotime($raw['pub_date']))
            : now()->toDateTime()->format('Y-m-d H:i:s');

        return [
            'title'        => $raw['headline']['main'] ?? '',
            'content'      => $raw['abstract'] ?? '',
            'category'     => $raw['section_name'] ?? 'general',
            'source'       => 'The New York Times',
            'published_at' => $publishedAt,
        ];
    }
}
