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
     *      @OA\Response(response=200, description="Success", @OA\JsonContent (ref="#/components/schemas/UserPreference")),
     *      @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(
     *                @OA\Property(property="message", type="string", example="Unauthenticated.")
     *            ))
     * )
     */
    public function show()
    {
        $prefs = $this->userPreferenceService->getUserPreference();

        return response()->json($prefs);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     * path="/api/user/preferences",
     * summary="Update user preferences",
     * tags={"User Preferences"},
     * security={{"sanctum":{}}},
     *
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="preferred_sources", type="array", @OA\Items(type="string")),
     * @OA\Property(property="preferred_categories", type="array", @OA\Items(type="string")),
     * @OA\Property(property="preferred_authors", type="array", @OA\Items(type="string"))
     * )
     * ),
     *
     * @OA\Response(
     * response=200,
     * description="Preferences updated successfully.",
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="message", type="string", example="Preferences updated successfully."),
     * @OA\Property(
     * property="data",
     * ref="#/components/schemas/UserPreference"
     * )
     * )
     * ),
     * @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unauthenticated.")
     * )),
     * @OA\Response(response=422, description="Validation error", @OA\JsonContent(
     *  @OA\Property(property="message", type="string", example="Invalid source")
     *  )))
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
