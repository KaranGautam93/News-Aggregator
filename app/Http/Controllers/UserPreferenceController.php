<?php

namespace App\Http\Controllers;

use App\Services\UserPreferenceService;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    /**
     * @var UserPreferenceService
     */
    protected UserPreferenceService $userPreferenceService;

    public function __construct(UserPreferenceService $userPreferenceService)
    {
        $this->userPreferenceService = $userPreferenceService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get(
     *      path="/api/user/preferences",
     *      summary="Get user preferences",
     *      tags={"User Preferences"},
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Success")
     * )
     *
     * @OA\SecurityScheme(
     *      securityScheme="sanctum",
     *      type="http",
     *      scheme="bearer",
     *      bearerFormat="Token"
     *  )
     *
     * @OA\Parameter(
     *          name="Accept",
     *          in="header",
     *          required=false,
     *          description="Response content type",
     *          @OA\Schema(type="string", default="application/json")
     *      )
     */
    public function show()
    {
        $prefs = $this->userPreferenceService->getUserPreference();

        return response()->json($prefs);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'preferred_sources' => 'array',
            'preferred_categories' => 'array',
            'preferred_authors' => 'array',
        ]);

        $request = $request->only(['preferred_sources', 'preferred_categories', 'preferred_authors']);

        if (!$this->userPreferenceService->isValidUserPreferenceRequest($request)) {
            return response()->json(['message' => 'Invalid source'], 400);
        }

        $prefs = $this->userPreferenceService
            ->updateUserPreference($request);

        return response()->json([
            'message' => 'Preferences updated successfully.',
            'data' => $prefs,
        ]);
    }
}
