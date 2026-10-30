<?php

namespace Database\Seeders;

use App\Models\Sanad\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $setting = Setting::first();

        if ($setting === null) {
            $setting = Setting::create([
                'logo_header'  => '',
                'logo_footer'  => '',
                'favicon'      => '',
                'email'        => 'info@sanadcx.com',
                'phone'        => '01099977904',
                'other_phone'  => '+201099977904',
                'whatsapp'     => '+201099977904',
                'facebook'     => '#',
                'instagram'    => '#',
                'twitter'      => '#',
                'snapchat'     => '#',
                'linkedin'     => '#',
                'youtube'      => '#',
                'tiktok'       => '#',
            ]);
        } else {
            $setting->update([
                'email'       => 'info@sanadcx.com',
                'phone'       => '+201099977904',
                'other_phone' => '+201099977904',
                'whatsapp'    => '+201099977904',
            ]);
        }

        $setting->translations()->updateOrCreate(['locale' => 'ar'], [
            'website_name' => 'سند CX',
            'footer_text'  => 'شريكك الاستراتيجي لتعهيد وإدارة خدمات رعاية العملاء والاتصالات بالتشغيل المباشر',
            'copyright'    => '© ' . date('Y') . ' Sanad CX. جميع الحقوق محفوظة.',
            'location'     => '',
        ]);

        $setting->translations()->updateOrCreate(['locale' => 'en'], [
            'website_name' => 'Sanad CX',
            'footer_text'  => 'Your strategic partner for outsourcing and managing customer care and communications services with direct operation.',
            'copyright'    => '© ' . date('Y') . ' Sanad CX. All rights reserved. Sanad CX is an operational brand powered by Mada Co llc.',
            'location'     => '',
        ]);
    }
}
