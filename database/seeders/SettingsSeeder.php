<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Home Page Settings
            ['key' => 'home_why_choose_eyebrow', 'value' => 'Why Lumos?'],
            ['key' => 'home_why_choose_title', 'value' => 'Dedicated to Your ##Baby\'s## First Room'],
            ['key' => 'home_why_choose_desc', 'value' => 'As Sri Lanka\'s only specialized nursery design studio, we understand that a baby\'s room is more than just furniture—it\'s a sanctuary for growth, sleep, and dreams.'],
            ['key' => 'home_services_eyebrow', 'value' => 'Our Expertise'],
            ['key' => 'home_services_title', 'value' => 'Services & ##Specialized## Products'],

            // Default CTA Links
            ['key' => 'home_cta1_label', 'value' => 'Products'],
            ['key' => 'home_cta1_sublabel', 'value' => 'Bespoke baby gear'],
            ['key' => 'home_cta1_link', 'value' => '{{SITE_URL}}/services?type=products'],

            ['key' => 'home_cta2_label', 'value' => 'Services'],
            ['key' => 'home_cta2_sublabel', 'value' => 'Nursery design packages'],
            ['key' => 'home_cta2_link', 'value' => '{{SITE_URL}}/services?type=services'],

            ['key' => 'home_cta3_label', 'value' => 'Inquiry'],
            ['key' => 'home_cta3_sublabel', 'value' => 'Request a custom quote'],
            ['key' => 'home_cta3_link', 'value' => '{{SITE_URL}}/contact'],

            // About Page CMS Seeds
            ['key' => 'about_banner_title', 'value' => 'About Lumos'],
            ['key' => 'about_story_eyebrow', 'value' => 'Our Story'],
            ['key' => 'about_story_title', 'value' => 'Creating Tiny Dreams & ##Safe## Spaces Since 2021'],
            ['key' => 'about_story_lead', 'value' => 'Lumos is a dedicated interior design studio based in Sri Lanka, specializing exclusively in nursery and baby room aesthetics. We are the first of our kind in the country, committed to creating tiny dreams for your little ones.'],
            ['key' => 'about_story_body1', 'value' => 'From custom-made round cribs and wardrobes to specialized nursery lighting and backlit wall decor, we provide comprehensive setups that blend safety, comfort, and unmatched style. Our projects are highly personalized, integrating custom name signs and specialized textiles to make every room unique.'],
            ['key' => 'about_story_body2', 'value' => 'We maintain close partnerships with elite woodworkers and safety experts to construct child-safe spaces. Led by Eng. Janith Wijesinghe, we combine engineering precision with creative design to make nurseries safe, healthy, and magical.'],
            ['key' => 'about_founder_sig_lbl', 'value' => 'Founder & Lead Engineer, Lumos'],
            ['key' => 'about_founder_sig_text', 'value' => 'Eng. Janith Wijesinghe'],
            ['key' => 'about_founder_quote', 'value' => 'A child\'s environment shapes their early growth. We design every crib and backlit panel with absolute love, safety, and attention to detail.'],
            ['key' => 'about_meta_title', 'value' => 'Our Story - Lumos Nursery Design Studio Sri Lanka'],
            ['key' => 'about_meta_description', 'value' => 'Discover the journey of Lumos, Sri Lanka\'s first specialized kids interior sanctuary design house. Led by Eng. Janith Wijesinghe, we construct safe, dream nursery spaces.'],
            ['key' => 'about_meta_keywords', 'value' => 'about lumos, kids room designers Sri Lanka, non-toxic baby furniture, Janith Wijesinghe, safety certified nursery Sri Lanka'],
            ['key' => 'about_story_image1', 'value' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=800'],
            ['key' => 'about_story_image2', 'value' => 'https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&q=80&w=800'],
            ['key' => 'about_story_image3', 'value' => 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=800'],
            ['key' => 'about_founder_image', 'value' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=800'],

            // Inquiry & Contact Page Settings
            ['key' => 'contact_banner_title', 'value' => 'Contact Our Studio'],
            ['key' => 'contact_eyebrow', 'value' => 'Connect with Lumos'],
            ['key' => 'contact_title', 'value' => 'Let\'s Design Your ##Nursery##'],
            ['key' => 'contact_lead', 'value' => 'Speak to a nursery designer today. We are available to assess your room and prepare a custom space proposal.'],
            ['key' => 'contact_sales_lbl', 'value' => 'Design & Consulting Desk'],
            ['key' => 'contact_sales_phone', 'value' => '+94 77 123 4567'],
            ['key' => 'contact_sales_hours', 'value' => 'Mon–Sat • 9:00 AM – 6:00 PM'],
            ['key' => 'contact_support_lbl', 'value' => 'Production & Delivery'],
            ['key' => 'contact_support_phone', 'value' => '+94 77 987 6543'],
            ['key' => 'contact_support_hours', 'value' => 'Support & Inquiries Hotline'],

            // Factory & Branch Location Settings
            ['key' => 'contact_factory_badge', 'value' => 'Design Studio'],
            ['key' => 'contact_factory_title', 'value' => 'Colombo 03, Sri Lanka'],
            ['key' => 'contact_factory_address', 'value' => "No. 15, Galle Road,\nColombo 03,\nSri Lanka"],
            ['key' => 'contact_factory_map', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.7!2d79.8499!3d6.9271!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2593f55555555%3A0x1!2sColombo+03!5e0!3m2!1sen!2slk!4v1700000000000'],

            ['key' => 'contact_branch_badge', 'value' => 'Main Workshop'],
            ['key' => 'contact_branch_title', 'value' => 'Katana, Gampaha'],
            ['key' => 'contact_branch_address', 'value' => "No. 81/B, Kaluwarippuwa,\nKatana, Gampaha,\nSri Lanka"],
            ['key' => 'contact_branch_map', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.6!2d79.9862!3d7.1124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2f8ae7adc3f31%3A0x1!2sKatana%2C+Gampaha!5e0!3m2!1sen!2slk!4v1700000000001'],

            // QR Code Settings
            ['key' => 'contact_qr_title', 'value' => 'Scan to Call'],
            ['key' => 'contact_qr_desc', 'value' => 'Quickly reach our design team from your mobile device.'],
            ['key' => 'contact_qr_data', 'value' => 'tel:+94771234567'],

            // Homepage SEO Metadata Seeds
            ['key' => 'home_meta_title', 'value' => 'Lumos Nursery & Baby Room Interior Design Studio Sri Lanka'],
            ['key' => 'home_meta_description', 'value' => 'Lumos is Sri Lanka\'s first specialized luxury nursery design and kids interior studio. We create tiny dreams with bespoke cribs and safe spaces.'],
            ['key' => 'home_meta_keywords', 'value' => 'nursery design Sri Lanka, baby room interior Colombo, kids furniture, custom cribs'],
            ['key' => 'home_og_image', 'value' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=800'],

            // Footer Info
            ['key' => 'footer_phone', 'value' => '+94 77 123 4567'],
            ['key' => 'footer_email', 'value' => 'hello@lumos.lk'],
            ['key' => 'footer_address', 'value' => 'No. 15, Galle Road, Colombo 03, Sri Lanka'],

            // New Banner Background Images
            ['key' => 'about_banner_image', 'value' => 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=1600'],
            ['key' => 'contact_banner_image', 'value' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&q=80&w=1600'],
            ['key' => 'gallery_banner_image', 'value' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=1600'],
            ['key' => 'services_banner_image', 'value' => 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=1600'],

            // Footer Metadata & Copyright
            ['key' => 'footer_description', 'value' => 'Sri Lanka\'s first and only specialized interior design studio dedicated to creating "tiny dreams" through bespoke nursery and baby room setups.'],
            ['key' => 'footer_copyright', 'value' => 'Lumos Nursery Interior Studio. All rights reserved.'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
