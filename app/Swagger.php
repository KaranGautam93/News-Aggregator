<?php

namespace App;

/**
 * @OA\Info(
 *        title="Personalized News Aggregator",
 *        version="1.0.0",
 *        description="Allows news agggregation and feed generation service",
 *        @OA\Contact(email="karankumar03902@gmail.com"),
 *        @OA\License(name="MIT", url="https://opensource.org/licenses/MIT")
 *    )
 *
 * @OA\Schema(
 *     schema="Article",
 *     type="object",
 *     title="Article",
 *     description="Schema for a news article",
 *     @OA\Property(property="id", type="string", example="1"),
 *     @OA\Property(property="title", type="string", example="Apple Unveils New AI Tools"),
 *     @OA\Property(property="category", type="string", example="Technology"),
 *     @OA\Property(property="source", type="string", example="The Guardian"),
 *     @OA\Property(property="author", type="string", example="John Doe"),
 *     @OA\Property(property="published_at", type="string", format="date-time", example="2025-06-23 10:00:00"),
 * )
 *
 * @OA\Schema(
 *      schema="ArticleComplete",
 *      type="object",
 *      title="Article",
 *      description="Schema for a news article",
 *      @OA\Property(property="id", type="string", example="1"),
 *      @OA\Property(property="title", type="string", example="Apple Unveils New AI Tools"),
 *      @OA\Property(property="category", type="string", example="Technology"),
 *     @OA\Property(property="content", type="string", example="Technology si ne de ve vu aljd"),
 *      @OA\Property(property="source", type="string", example="The Guardian"),
 *      @OA\Property(property="author", type="string", example="John Doe"),
 *      @OA\Property(property="published_at", type="string", format="date-time", example="2025-06-23 10:00:00"),
 *  )
 */
class Swagger
{

}
