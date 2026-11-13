<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Tests\TestCase;

class ConsultationRequestTest extends TestCase
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

    public function test_consultation_request_persists_service_interest(): void
    {
        $response = $this->postJson(route('website.consultation.store'), [
            'full_name' => 'Test User',
            'company_name' => 'Test Company',
            'mobile_whatsapp' => '01000000000',
            'daily_contact_volume' => '100',
            'service_interest' => 'Sanad AI',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('consultation_requests', [
            'full_name' => 'Test User',
            'service_interest' => 'Sanad AI',
        ]);
    }

    public function test_consultation_request_accepts_the_homepage_camel_case_field(): void
    {
        $response = $this->postJson(route('website.consultation.store'), [
            'full_name' => 'Test User',
            'company_name' => 'Test Company',
            'mobile_whatsapp' => '01000000000',
            'daily_contact_volume' => '100',
            'serviceInterest' => 'BPO',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('consultation_requests', [
            'full_name' => 'Test User',
            'service_interest' => 'BPO',
        ]);
    }

    public function test_consultation_request_remains_compatible_when_interest_is_omitted(): void
    {
        $response = $this->postJson(route('website.consultation.store'), [
            'full_name' => 'Legacy User',
            'company_name' => 'Legacy Company',
            'mobile_whatsapp' => '01000000000',
            'daily_contact_volume' => '100',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('consultation_requests', [
            'full_name' => 'Legacy User',
            'service_interest' => null,
        ]);
    }

    public function test_validation_errors_keep_the_website_response_format(): void
    {
        $this->postJson(route('website.consultation.store'), [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['full_name', 'company_name', 'mobile_whatsapp', 'daily_contact_volume']);
    }
}
