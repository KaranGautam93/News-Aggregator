<?php

namespace Tests\Unit\Transformers;

use App\constants\ArticleSources;
use App\Transformers\NYTTransformer;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class NYTTransformerTest extends TestCase
{
    #[DataProvider('nytArticleProvider')] public function test_nyt_article_is_transformed_correctly(array $input, array $expected)
    {
        $transformer = new NYTTransformer();
        $transformed = $transformer->transform($input);

        foreach ($expected as $key => $value) {
            $this->assertEquals($value, $transformed[$key]);
        }
    }

    public static function nytArticleProvider(): array
    {
        return [
            'normal article' => [
                'input' => [
                    'headline' => ['main' => 'Climate Crisis Deepens'],
                    'byline' => ['original' => 'By Jane Doe'],
                    'pub_date' => '2025-06-24T12:00:00Z',
                    'web_url' => 'https://www.nytimes.com/2025/06/24/climate.html',
                    'lead_paragraph' => 'New data shows the climate crisis accelerating...',
                    'section_name' => 'Science',
                ],
                'expected' => [
                    'title' => 'Climate Crisis Deepens',
                    'source' => ArticleSources::NEW_YORK_SOURCE,
                    'category' => 'Science',
                ],
            ],
            'missing optional fields' => [
                'input' => [
                    'headline' => ['main' => 'Stock Market Update'],
                    'web_url' => 'https://www.nytimes.com/2025/06/24/markets.html',
                ],
                'expected' => [
                    'title' => 'Stock Market Update',
                    'source' => ArticleSources::NEW_YORK_SOURCE,
                    'category' => 'general',
                ],
            ],
        ];
    }
}
