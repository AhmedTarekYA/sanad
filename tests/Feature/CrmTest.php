<?php

namespace Tests\Feature;

use App\Models\CRM\CrmUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrmTest extends TestCase
{
    use RefreshDatabase;

    private string $baseUrl = 'http://crm.sanadcx.com';

    public function test_crm_login_page_renders(): void
    {
        $this->get($this->baseUrl.'/login')->assertOk();
    }

    public function test_crm_user_can_login_and_reach_dashboard_with_whatsapp_pages(): void
    {
        $user = CrmUser::factory()->create([
            'email' => 'crm@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post($this->baseUrl.'/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('crm.dashboard'));

        $this->actingAs($user, 'crm')
            ->get($this->baseUrl.'/')
            ->assertOk()
            ->assertSee(route('crm.whatsapp_business_settings'))
            ->assertSee(route('crm.whatsapp_setup'))
            ->assertSee(route('crm.whatsapp_chat'))
            ->assertSee(route('crm.whatsapp_broadcasts'))
            ->assertSee(route('crm.whatsapp_contacts'))
            ->assertSee(route('crm.whatsapp_labels'))
            ->assertSee(route('crm.whatsapp_quick_replies'))
            ->assertSee(route('crm.whatsapp_business_hours'))
            ->assertSee(route('crm.whatsapp_analytics'));

        foreach ([
            'crm.whatsapp_business_settings',
            'crm.whatsapp_setup',
            'crm.whatsapp_chat',
            'crm.whatsapp_broadcasts',
            'crm.whatsapp_contacts',
            'crm.whatsapp_labels',
            'crm.whatsapp_quick_replies',
            'crm.whatsapp_business_hours',
            'crm.whatsapp_analytics',
        ] as $routeName) {
            $this->actingAs($user, 'crm')
                ->get(route($routeName))
                ->assertOk();
        }
    }

    public function test_inactive_or_expired_crm_user_cannot_login(): void
    {
        $inactive = CrmUser::factory()->inactive()->create([
            'email' => 'inactive@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->post($this->baseUrl.'/login', [
            'email' => $inactive->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $expired = CrmUser::factory()->expired()->create([
            'email' => 'expired@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->post($this->baseUrl.'/login', [
            'email' => $expired->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');
    }
}
