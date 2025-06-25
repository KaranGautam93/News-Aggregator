<?php

namespace App\Http\Controllers;

use App\constants\ArticleSources;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController
{

    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index(Request $request)
    {
        $source = $request->get('source');

        if (!in_array(strtolower($source), ArticleSources::VALID_SOURCES)) {
            return response()->json(['message' => 'Invalid source'], 400);
        }

        $articles = $this->articleService->listArticles($request->all());
        return response()->json($articles);
    }

    public function show($id)
    {
        $article = $this->articleService->getArticleDetail($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        return response()->json($article);
    }

}
