<?php

namespace App\Console\Commands;

use App\Services\ArticleService;
use App\Services\NewsFetcherService;
use Illuminate\Console\Command;

class FetchArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch articles from multiple sources';

    /**
     * Execute the console command.
     */
    public function handle(NewsFetcherService $newsFetcherService, ArticleService $articleService)
    {
        $articles = $newsFetcherService->fetchFromAll();
        $articleService->storeArticles($articles);
    }
}
