<?php

namespace App\Repository;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleRepository
{
    public function getPaginatedArticles(array $filters): LengthAwarePaginator
    {
        return Article::query()
            ->when($filters['keyword'] ?? null, fn($q, $keyword) => $q->where('title', 'like', "%{$keyword}%"))
            ->when($filters['author'] ?? null, fn($q, $keyword) => $q->where('author', 'like', "%{$keyword}%"))
            ->when($filters['date'] ?? null, fn($q, $date) => $q->whereDate('published_at', $date))
            ->when($filters['category'] ?? null, fn($q, $category) => $q->where('category', $category))
            ->when($filters['source'] ?? null, fn($q, $source) => $q->where('source', $source))
            ->orderByDesc('published_at')
            ->paginate($filters['per_page'] ?? 10);
    }

    public function findById(int $id): ?Article
    {
        return Article::find($id);
    }

}
