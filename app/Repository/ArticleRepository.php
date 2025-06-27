<?php

namespace App\Repository;

use App\Models\Article;
use App\Models\UserPreference;
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
            ->select(['id', 'title', 'author', 'category', 'source', 'published_at'])
            ->paginate($filters['per_page'] ?? 10);
    }

    public function findById(int $id): ?Article
    {
        return Article::find($id)?->first(['id', 'title', 'author', 'category', 'source', 'published_at', 'mongo_id']);
    }

    public function addArticle($data): ?Article
    {
        return Article::updateOrCreate(
            ['title' => $data['title'], 'source' => $data['source']],
            [
                'category' => $data['category'],
                'published_at' => $data['published_at'],
                'author' => $data['authors'],
            ]
        );
    }

    public function getPreferredArticles(UserPreference $prefs, $perPage): LengthAwarePaginator
    {
        $query = Article::query();

        if (!empty($prefs->preferred_sources)) {
            $query->whereIn('source', $prefs->preferred_sources);
        }

        if (!empty($prefs->preferred_categories)) {
            $query->whereIn('category', $prefs->preferred_categories);
        }

        if (!empty($prefs->preferred_authors)) {
            $query->whereJsonContains('authors', $prefs->preferred_authors);
        }

        return $query->latest('published_at')->select(['id', 'category', 'source', 'author', 'title', 'published_at'])->paginate($perPage);
    }

}
