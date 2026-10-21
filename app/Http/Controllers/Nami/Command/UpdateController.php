<?php

namespace App\Http\Controllers\Nami\Command;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class UpdateController extends Controller
{
    public function index()
    {
        // Read stored commit (fallback to empty string)
        $storedCommit = @trim(file_get_contents(storage_path('app/current_commit.txt'))) ?: '';

        // Build GitHub API URL
        $repoPath = sprintf(
            "repos/%s/%s/commits/%s",
            env('GITHUB_PROVIDER', 'Nami-BackEnd'),
            env('GITHUB_REPO'),
            env('GITHUB_BRANCH', 'main')
        );

        $response = Http::withToken(env('GITHUB_TOKEN'))
            ->accept('application/vnd.github.v3+json')
            ->get("https://api.github.com/$repoPath");

        if ($response->failed()) {
            return response()->json([
                'error'   => 'Failed to fetch commit from GitHub',
                'details' => $response->body(),
            ], 500);
        }

        $latestCommit = $response->json('sha');

        return [
            'current'          => $storedCommit,
            'latest'           => $latestCommit,
            'update_available' => $latestCommit !== $storedCommit,
        ];
    }
}
