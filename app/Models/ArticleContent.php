<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;



class ArticleContent extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'article_contents';

    protected $fillable = ['mongo_id', 'content'];
}
