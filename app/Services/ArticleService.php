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
        foreach ($rawArticles as $data) {
            $article = Article::updateOrCreate(
                ['title' => $data['title'], 'source' => $data['source']],
                [
                    'category'     => $data['category'],
                    'published_at' => $data['published_at'],
                    'author'       => $data['authors'],
                ]
            );

            if ($article->mongo_id) {
                ArticleContent::where('_id', $article->mongo_id)
                    ->update(['content' => $data['content']]);
            } else {
                $mongo = ArticleContent::create([
                    'content' => $data['content'],
                ]);

                $article->mongo_id = $mongo->_id;
                $article->save();
            }

        }
    }

}

