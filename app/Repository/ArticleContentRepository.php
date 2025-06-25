<?php

namespace App\Repository;

use App\Models\ArticleContent;

class ArticleContentRepository
{
    public function getContentByMongoId(string $mongoId): ?ArticleContent
    {
        return ArticleContent::where('mongo_id', $mongoId)->first();
    }
}
