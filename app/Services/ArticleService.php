<?php

namespace App\Services;

use App\Repository\ArticleRepository;
use App\Repository\ArticleContentRepository;
use Illuminate\Support\Facades\Cache;

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
        $key = 'articles_' . md5(json_encode($filters));
        $articles = Cache::tags(['articles'])->remember($key, now()->addMinutes(2), function () use ($filters) {
            return $this->articleRepo->getPaginatedArticles($filters);
        });
        return $articles;
    }

    public function getArticleDetail(int $id)
    {
        $article = $this->articleRepo->findById($id);

        if (empty($article)) return null;

        $content = $this->contentRepo->getContentByMongoId($article->mongo_id);
        unset($article->mongo_id);

        return [
            ...$article->toArray(),
            'content' => $content?->content ?? '',
        ];
    }

    public function storeArticles(array $rawArticles)
    {
        foreach ($rawArticles as $data) {
            $article = $this->articleRepo->addArticle($data);

            if ($article->mongo_id) {
                $this->contentRepo->updateContent($data, $article->mongo_id);
            } else {
                $mongo = $this->contentRepo->addContent($data);
                $article->mongo_id = $mongo->_id;
                $article->save();
            }

        }
    }

}

