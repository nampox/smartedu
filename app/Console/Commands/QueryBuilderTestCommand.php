<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\QueryBuilderService;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;

class QueryBuilderTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'query:test {--user=} {--filter=} {--sort=} {--include=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Query Builder functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Query Builder functionality...');
        $this->line('');

        // Test basic query
        $this->testBasicQuery();
        $this->line('');

        // Test with filters
        $this->testWithFilters();
        $this->line('');

        // Test with sorting
        $this->testWithSorting();
        $this->line('');

        // Test with includes
        $this->testWithIncludes();
        $this->line('');

        // Test complex query
        $this->testComplexQuery();
        $this->line('');

        $this->info('Query Builder test completed!');
    }

    private function testBasicQuery()
    {
        $this->info('1. Testing basic query...');
        
        $users = User::take(5)->get();
        $this->line("Found {$users->count()} users");
        
        foreach ($users as $user) {
            $this->line("- {$user->name} ({$user->email})");
        }
    }

    private function testWithFilters()
    {
        $this->info('2. Testing with filters...');
        
        $request = new Request([
            'filter' => [
                'name' => 'Test',
            ]
        ]);
        
        $queryBuilder = QueryBuilderService::forUsers(User::query(), $request);
        $users = $queryBuilder->get();
        
        $this->line("Found {$users->count()} users with name containing 'Test'");
        
        foreach ($users as $user) {
            $this->line("- {$user->name} ({$user->email})");
        }
    }

    private function testWithSorting()
    {
        $this->info('3. Testing with sorting...');
        
        $request = new Request([
            'sort' => '-created_at'
        ]);
        
        $queryBuilder = QueryBuilderService::forUsers(User::query(), $request);
        $users = $queryBuilder->take(3)->get();
        
        $this->line("Found {$users->count()} users sorted by created_at (desc)");
        
        foreach ($users as $user) {
            $this->line("- {$user->name} (created: {$user->created_at})");
        }
    }

    private function testWithIncludes()
    {
        $this->info('4. Testing with includes...');
        
        $request = new Request([
            'include' => ['roles', 'media']
        ]);
        
        $queryBuilder = QueryBuilderService::forUsers(User::query(), $request);
        $users = $queryBuilder->take(2)->get();
        
        $this->line("Found {$users->count()} users with relationships loaded");
        
        foreach ($users as $user) {
            $this->line("- {$user->name}");
            $this->line("  Roles: " . $user->roles->count());
            $this->line("  Media: " . $user->media->count());
        }
    }

    private function testComplexQuery()
    {
        $this->info('5. Testing complex query...');
        
        $request = new Request([
            'filter' => [
                'name' => 'Test',
            ],
            'sort' => '-created_at',
            'include' => ['roles'],
            'per_page' => 3
        ]);
        
        $queryBuilder = QueryBuilderService::forUsers(User::query(), $request);
        $result = QueryBuilderService::response($queryBuilder, 3);
        
        $this->line("Complex query result:");
        $this->line("- Total: {$result['pagination']['total']}");
        $this->line("- Per page: {$result['pagination']['per_page']}");
        $this->line("- Current page: {$result['pagination']['current_page']}");
        $this->line("- Data count: " . count($result['data']));
        
        foreach ($result['data'] as $user) {
            $this->line("  - {$user->name} ({$user->email})");
        }
    }
}