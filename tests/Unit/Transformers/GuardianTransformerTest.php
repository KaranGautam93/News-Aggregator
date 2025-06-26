<?php

namespace Tests\Unit\Transformers;

use Tests\TestCase;
use App\Transformers\GuardianTransformer;
use App\constants\ArticleSources;
class GuardianTransformerTest extends TestCase
{
    /**
     * @dataProvider guardianArticleProvider
     */
    public function test_guardian_article_is_transformed_properly(array $input, array $expected)
    {
        $transformer = new GuardianTransformer();
        $result = $transformer->transform($input);

        foreach ($expected as $key => $value) {
            $this->assertEquals($value, $result[$key]);
        }
    }

    public static function guardianArticleProvider(): array
    {
        return [
            'normal article' => [
                'input' => [
                    'webTitle' => 'AI Takes Over World',
                    'webUrl' => 'https://www.theguardian.com/ai-world',
                    'fields' => [
                        'body' => 'Full content of the article.',
                        'byline' => 'Jane Doe',
                        'publication' => '2025-06-01T10:00:00Z',
                    ],
                    'sectionName' => 'Technology',
                ],
                'expected' => [
                    'title' => 'AI Takes Over World',
                    'source' => ArticleSources::THE_GUARDIAN_SOURCE,
                ],
            ],
            'missing body field' => [
                'input' => [
                    'webTitle' => 'Empty Body',
                    'webUrl' => 'https://www.theguardian.com/empty-body',
                    'fields' => [
                        'byline' => 'John Smith',
                        'publication' => '2025-06-02T11:00:00Z',
                    ],
                    'sectionName' => 'Politics',
                ],
                'expected' => [
                    'title' => 'Empty Body',
                    'source' => ArticleSources::THE_GUARDIAN_SOURCE,
                ],
            ],
        ];
    }
}

