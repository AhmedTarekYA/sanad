<?php

namespace Tests\Feature;

use App\Enums\AdminTypeisEnum;
use App\Models\Sanad\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Tests\TestCase;

class DashboardRenderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([
            LaravelLocalizationRedirectFilter::class,
            LocaleSessionRedirect::class,
        ]);
    }

    public function test_dashboard_renders_visitor_stats(): void
    {
        $admin = Admin::create([
            'name' => 'Test Admin',
            'email' => 'test-admin@example.com',
            'phone' => '01000000000',
            'password' => bcrypt('password'),
            'admin_type' => AdminTypeisEnum::Developer->value,
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/dashboard');

        $response->assertOk();
        $response->assertSee('chartVisits', false);
    }
}
