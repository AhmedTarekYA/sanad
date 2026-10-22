<?php

namespace Tests\Feature;

use App\Models\Sanad\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardRenderTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_renders_visitor_stats(): void
    {
        $admin = Admin::first();

        $response = $this->actingAs($admin, 'admin')->get('/dashboard');

        $response->assertOk();
        $response->assertSee('chartVisits', false);
    }
}
