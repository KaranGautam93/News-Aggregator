<?php

namespace App\Transformers;

use App\Transformers\NewsTransformerInterface;

class NewsApiTransformer implements NewsTransformerInterface
{

    public function transform(array $raw): array
    {
        $category = $raw['categories'][0]['label'] ?? 'general';
        $category = explode('/', $category)[1] ?? 'general';

        $publishedAt = !empty($raw['dateTime']) ? date('Y-m-d H:i:s', strtotime($raw['dateTime']))
            : now()->toDateTime()->format('Y-m-d H:i:s');

        return [
            'title' => $raw['title'] ?? '',
            'content' => $raw['body'] ?? '',
            'category' => $category,
            'source' => 'News Api',
            'published_at' => $publishedAt,
        ];
    }
}
