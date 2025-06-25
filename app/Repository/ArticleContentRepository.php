<?php

namespace App\Repository;

use App\Models\ArticleContent;

class ArticleContentRepository
{
    public function getContentByMongoId(string $mongoId): ?ArticleContent
    {
        return ArticleContent::where('_id', $mongoId)->first();
    }
}
