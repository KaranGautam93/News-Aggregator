<?php

namespace App\Http\Controllers;

use App\constants\ArticleSources;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController
{

    /**
     * @var ArticleService
     */
    protected ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/api/articles",
     *      summary="List all articles with filters",
     *      tags={"Articles"},
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer"), description="Page number"),
     *      @OA\Parameter(name="per_page", in="query", required=false, @OA\Schema(type="integer"), description="Items per page"),
     *      @OA\Parameter(name="keyword", in="query", required=false, @OA\Schema(type="string"), description="Title keyword of news"),
     *      @OA\Parameter(name="category", in="query", required=false, @OA\Schema(type="string"), description="News category"),
     *      @OA\Parameter(name="source", in="query", required=false, @OA\Schema(type="string"), description="News source"),
     *      @OA\Parameter(name="date", in="query", required=false, @OA\Schema(type="string", format="date"), description="News publication date"),
     *      @OA\Response(
     *          response=200,
     *          description="List of articles",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Article"))
     *      ),
     *      @OA\Response(
     *           response=400,
     *           description="Bad Request",
     *           @OA\JsonContent(@OA\Property(type="string", property="message", example="Invalid source"))
     *       ),
     *
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(
     *                @OA\Property(property="message", type="string", example="Unauthenticated.")
     *            ))
     *  )
     */
    public function index(Request $request)
    {
        $source = $request->get('source');

        if (!empty($source) &&
            !in_array(strtolower($source), ArticleSources::VALID_SOURCES)) {
            return response()->json(['message' => 'Invalid source'], 400);
        }

        $articles = $this->articleService->listArticles($request->all());
        return response()->json($articles);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *      path="/api/articles/{id}",
     *      summary="Get details of a single article",
     *      tags={"Articles"},
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
     *      @OA\Response(response=200, description="Article detail", @OA\JsonContent(ref="#/components/schemas/ArticleComplete")),
     *      @OA\Response(response=404, description="Not found", @OA\JsonContent(@OA\Property (type="string", property="message", example="Article not found"))),
     *      @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(
     *                @OA\Property(property="message", type="string", example="Unauthenticated.")
     *            ))
     *  )
     */
    public function show($id)
    {
        $article = $this->articleService->getArticleDetail($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        return response()->json($article);
    }

}
