<?php

namespace Tests\Unit\Transformers;

use App\constants\ArticleSources;
use App\Transformers\NewsApiTransformer;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class NewsApiTransformerTest extends TestCase
{
    #[DataProvider('newsApiArticleProvider')] public function test_newsapi_article_is_transformed_correctly(array $input, array $expected)
    {
        $transformer = new NewsApiTransformer();
        $transformed = $transformer->transform($input);

        foreach ($expected as $key => $value) {
            $this->assertEquals($value, $transformed[$key]);
        }
    }

    public static function newsApiArticleProvider(): array
    {
        return [
            'normal article' => [
                'input' => [
                    'title' => 'Global Markets Surge',
                    'author' => 'John Doe',
                    'date' => '2025-06-25T10:00:00Z',
                    'url' => 'https://eventregistry.org/article/market-surge',
                    'body' => 'Markets are seeing major gains...',
                    'categories' => [
                        ['label' => 'news/Finance'],
                    ],
                ],
                'expected' => [
                    'title' => 'Global Markets Surge',
                    'source' => ArticleSources::NEWS_API_SOURCE,
                    'category' => 'Finance',
                ],
            ],
            'missing category' => [
                'input' => [
                    'title' => 'Tech Innovations Rise',
                    'url' => 'https://eventregistry.org/article/tech-rise',
                    'body' => 'New AI tools are trending...',
                    'author' => 'Jane Smith',
                ],
                'expected' => [
                    'title' => 'Tech Innovations Rise',
                    'source' => ArticleSources::NEWS_API_SOURCE,
                    'category' => 'general',
                ],
            ],
        ];
    }
}
