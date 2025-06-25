<?php

namespace App\Transformers;

use App\Transformers\NewsTransformerInterface;

class NewsApiTransformer implements NewsTransformerInterface
{

    public function transform(array $raw): array
    {
        $category = $raw['categories'][0]['label'] ?? 'general';
        $category = explode('/', $category)[1] ?? 'general';

        return [
            'title' => $raw['title'] ?? '',
            'content' => $raw['body'] ?? '',
            'category' => $category,
            'source' => 'News Api',
            'published_at' => $raw['dateTime'] ?? now()->toDateTimeString(),
        ];
    }
}
