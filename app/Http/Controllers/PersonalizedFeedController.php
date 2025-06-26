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
     */
    public function index(Request $request)
    {
        $res = $this->personalizedFeedService->generateFeed($request->get('per_page') ?? 10);

        if (!empty($res['error'])) {
            return response()->json([
                'message' => $res['error'],
            ], 400);
        }

        return response()->json($res);
    }
}
