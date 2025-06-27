<?php

namespace App\Repository;

use App\Models\ArticleContent;

class ArticleContentRepository
{
    public function getContentByMongoId(string $mongoId): ?ArticleContent
    {
        return ArticleContent::where('_id', $mongoId)->first();
    }

    public function updateContent($data, $mongoId)
    {
        ArticleContent::where('_id', $mongoId)
            ->update(['content' => $data['content']]);
    }

    public function addContent($data): ArticleContent
    {
        return ArticleContent::create([
            'content' => $data['content'],
        ]);
    }
}
