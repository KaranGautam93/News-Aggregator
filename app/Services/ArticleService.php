<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleContent;
use App\Repository\ArticleRepository;
use App\Repository\ArticleContentRepository;

class ArticleService
{
    public function __construct(
        protected ArticleRepository        $articleRepo,
        protected ArticleContentRepository $contentRepo
    )
    {
    }

    public function listArticles(array $filters)
    {
        return $this->articleRepo->getPaginatedArticles($filters);
    }

    public function getArticleDetail(int $id)
    {
        $article = $this->articleRepo->findById($id);
        if (!$article) return null;

        $content = $this->contentRepo->getContentByMongoId($article->mongo_id);

        return [
            ...$article->toArray(),
            'content' => $content?->content ?? '',
        ];
    }

    public function storeArticles(array $rawArticles)
    {
        foreach ($rawArticles as $raw) {
            $mongo = ArticleContent::create(['content' => $raw['content'] ?? '']);

            Article::updateOrCreate(
                ['title' => $raw['title']],
                [
                    'category' => $raw['category'] ?? 'general',
                    'source' => $raw['source'] ?? 'unknown',
                    'published_at' => now(), // parse if available
                    'mongo_id' => $mongo->_id,
                ]
            );
        }
    }

}

