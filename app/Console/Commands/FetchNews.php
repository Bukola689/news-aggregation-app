<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news from various APIs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $this->info('Starting news fetch...');
        
        // Fetch from NewsAPI

        $this->info('Fetching from NewsAPI...');

        $newsApiService = new NewsApiService();
        
        $newsApiService->fetchArticles();
        
        // Fetch from The Guardian
        $this->info('Fetching from The Guardian...');
        $guardianService = new GuardianService();
        $guardianService->fetchArticles();
        
        // Fetch from NY Times
        $this->info('Fetching from NY Times...');
        $nyTimesService = new NyTimesService();
        $nyTimesService->fetchArticles();
        
        $this->info('News fetch completed successfully.');
    }

}
