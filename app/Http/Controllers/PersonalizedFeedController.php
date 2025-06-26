<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\UserPreference;
use App\Services\PersonalizedFeedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalizedFeedController extends Controller
{
    /**
     * @var PersonalizedFeedService
     */
    protected PersonalizedFeedService $personalizedFeedService;

    /**
     * @param PersonalizedFeedService $personalizedFeedService
     */
    public function __construct(PersonalizedFeedService $personalizedFeedService)
    {
        $this->personalizedFeedService = $personalizedFeedService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * /**
     * @OA\Get(
     * path="/api/user/feed",
     * summary="Get personalized news feed for the user",
     * description="Returns a list of articles personalized based on the user's preferred sources, categories, and authors.",
     * operationId="getPersonalizedFeed",
     * tags={"User Feed"},
     * security={{"sanctum":{}}},
     *
     * @OA\Parameter(
     * name="page",
     * in="query",
     * description="Page number for pagination",
     * required=false,
     * @OA\Schema(type="integer", default=1)
     * ),
     * @OA\Parameter(
     * name="per_page",
     * in="query",
     * description="Number of articles per page",
     * required=false,
     * @OA\Schema(type="integer", default=10)
     * ),
     *
     * @OA\Response(
     * response=200,
     * description="List of personalized articles",
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="message", type="string", example="Feed fetched successfully."),
     * @OA\Property(
     * property="data",
     * type="array",
     * @OA\Items(ref="#/components/schemas/Article")
     * ),
     * @OA\Property(
     * property="meta",
     * type="object",
     * @OA\Property(property="current_page", type="integer", example=1),
     * @OA\Property(property="per_page", type="integer", example=10),
     * @OA\Property(property="total", type="integer", example=100)
     * )
     * )
     * ),
     *  @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(
     *  @OA\Property(property="message", type="string", example="Unauthenticated.")
     *  )),
     *  @OA\Response(response=404, description="Preference not found", @OA\JsonContent(
     *   @OA\Property(property="message", type="string", example="No preferences found. Please set preferences first.")
     *   )))
     * )
     * /
     */
    public function index(Request $request)
    {
        $res = $this->personalizedFeedService->generateFeed($request->get('per_page') ?? 10);

        if (!empty($res['error'])) {
            return response()->json([
                'message' => $res['error'],
            ], 404);
        }

        return response()->json($res);
    }
}
