<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertInitialDataToTheSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Ashrafuddin',
                    'email' => 'email@example.com',
                    'email_verified_at' => null,
                    'password' => '$2y$10$OlcFk/eoNqkPNT0ULyON/OZ/7wPlXSORACgn8N9qRgBSNTy7mHFIK',
                    'photo' => 'http://laracms.local/cms_assets/test/1026-200x300.jpg',
                    'first_name' => 'Mohammad',
                    'last_name' => 'Ferdousi',
                    'send_notification' => '1',
                    'remember_token' => 'remember_token',
                    'created_at' => '2021-09-06 04:51:23',
                    'updated_at' => '2021-09-06 04:51:23',
                    'reserved' => 1
                ],
                [
                    'id' => 2,
                    'name' => 'Jhon',
                    'email' => 'johndoe@gmail.com',
                    'email_verified_at' => '2021-09-06 06:00:34',
                    'password' => '$2y$10$TjQh/WPvugao.dfM3dTNBuDBTHP4LSQEGfbXJ/PhoiCA8SNA3jN3K',
                    'photo' => 'http://laracms.local/cms_assets/test/102-200x200.jpg',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'send_notification' => '1',
                    'remember_token' => '',
                    'created_at' => '2021-09-06 05:00:34',
                    'updated_at' => '2021-09-06 05:00:34',
                    'reserved' => 0
                ]
            ]

        );

        DB::table('about_us')->insert(
            [
                'id' => 1,
                'image' => 'http://laracms.local/cms_assets/front_page/about_us/about.jpg',
                'title' => 'Who We Are',
                'summary' => "ERA-InfoTech Ltd -A Joint Venture IT Company formed by Bank Asia Ltd, Ranks ITT Ltd of  Bangladesh and Sash Tech SG Pte. Ltd, Singapore. ERA commenced it’s journey on 11th November, 2002.",
                'url' => 'http://laracms.local/pages/about?item=3',
                'created_at' => '2021-09-06 05:00:34',
                'updated_at' => '2021-09-06 05:00:34',
            ]
        );

        DB::table('resource_infos')->insert(
            [
                'id' => 1,
                'commencement' => 2002,
                'number_of_installation' => 250,
                'customers' => 50,
                'team_members' => 175,
                'created_at' => '2021-09-06 05:00:34',
                'updated_at' => '2021-09-06 05:00:34',
            ]
        );

        DB::table('company_infos')->insert(
            [
                'id' => 1,
                'logo_src' => 'http://laracms.local/cms_assets/ERA-Logo.png',
                'logo_small_src' => 'http://laracms.local/cms_assets/ERA-Logo.png',
                'logo_alt' => 'Era-InfoTech Limited Logo',
                'root_url' => '/',
                'website_name' => 'Era-InfoTech Limited',
                'tagline' => 'end to end IT Solution Provider',
                'fax' => '',
                'phone' => '',
                'email' => 'info@erainfotechbd.com',
                'web' => 'https://erainfotechbd.com',
                'facebook' => 'https://www.facebook.com/ERAInfoTechLimitedBD/',
                'linkedin' => 'https://www.linkedin.com/company/erainfotech',
                'company_summary' => 'ERA-InfoTech Ltd -A Joint Venture IT Company formed by Bank Asia Ltd, Ranks ITT Ltd of Bangladesh and Sash Tech SG Pte. Ltd, Singapore. ERA commenced it’s journey on 11th November, 2002.',
                'open_days' => 'Sunday - Thursday',
                'duration' => '9:00 AM - 6:00 PM',
                'created_at' => '2021-09-06 05:00:34',
                'updated_at' => '2021-09-06 05:00:34',
            ]
        );

        DB::table('menus')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Header',
                    'slug' => 'header',
                    'order' => 1,
                    'created_at' => '2021-09-06 05:00:34',
                    'updated_at' => '2021-09-06 05:00:34',
                ],
                [
                    'id' => 2,
                    'name' => 'Footer',
                    'slug' => 'footer',
                    'order' => 2,
                    'created_at' => '2021-09-06 05:00:35',
                    'updated_at' => '2021-09-06 05:00:35',
                ]
            ]
        );

        DB::table('pages')->insert(
            [
                [
                    'id' => 1,
                    'title' => 'About',
                    'slug' => 'about',
                    'content' => '<section class=\"inner-page\">\n<div class=\"container\">\n<article class=\"entry entry-single\">\n<div class=\"entry-img\"><img class=\"img-fluid\" src=\"http://laracms.local/cms_assets/about/Pic-in-about-page-1.jpg\" width=\"1920\" height=\"900\" /></div>\n<br />\n<div class=\"entry-content\" style=\"text-align: justify; line-height: 30px;\">\n<p><strong>ERA-InfoTech Ltd</strong> -A Joint Venture IT Company formed by Bank Asia Ltd, Ranks ITT Ltd of Bangladesh and Sash Tech SG Pte. Ltd, Singapore. ERA commenced it&rsquo;s journey on 11th November, 2002. ERA has developed Centralized Real Time, Web Based Core Banking Solution both for Conventional &amp; Islamic, Agent Banking, Loan Originating &amp; Approval System, HR &amp; Payroll Management solution, ERP, Micro Finance solution, Mobile and System critical software for various business houses, including Banks, Multinational Companies and the Government. We have a large team of internationally certified software professionals with knowledge in Oracle, Microsoft, Java, etc. ERA has been a pioneer in developing several software solutions in the country. IT solutions for the government like Ektee Bari Ektee Khamar (EBEK) have taken ERA&rsquo;s capabilities to a different level and proves the diverse skill sets available in the company.</p>\n<p>ERA has achieved CMMI (Capability Maturity Model Integration) Dev.Level 3, ISO-9001:2015 (Quality Management System) &amp; ISO-27001:2013 (Information Security Management System). ERA is a member of Bangladesh Association of Software and Information Services (BASIS).</p>\n<p>ERA has achieved National Productivity &amp; Quality Excellence Award 2015 from National Productivity Organization (NPO), Ministries of Industries, Government of The People&rsquo;s Republic of Bangladesh. Also achieved Manthan Award, India, South Asia and Asia Pacific 2013 in Business and Financial Inclusion Category &amp; International Leadership in Quality by BID, Paris, France. ERA is committed to deliver quality products and services to it&rsquo;s valued clients.</p>\n</div>\n</article>\n<!-- End blog entry --></div>\n</section>\n<!-- ======= Counts Section ======= --> <!-- ======= Services Section ======= -->\n<section id=\"services\" class=\"services\">\n<div class=\"container\" data-aos=\"fade-up\">\n<div class=\"row gy-4\">\n<div class=\"col-lg-6 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"200\">\n<div class=\"service-box blue\"><i class=\"ri-discuss-line icon\"></i>\n<h3>Our Vision</h3>\n<p>To reinvent the way people use technology in their daily lives, empowering communities, for a better future.</p>\n</div>\n</div>\n<div class=\"col-lg-6 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"300\">\n<div class=\"service-box orange\"><i class=\"ri-discuss-line icon\"></i>\n<h3>Our Mission</h3>\n<p>To serve clients through integrated solutions by designing and developing the best and most efficient software through emphasizing the mutual relationship between technology and innovations.</p>\n</div>\n</div>\n</div>\n</div>\n</section>\n<!-- End Services Section -->',
                    'meta' => 'about',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 2,
                    'title' => 'Management',
                    'slug' => 'management',
                    'content' => 'Management page',
                    'meta' => 'management',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 3,
                    'title' => 'Core Banking Platform',
                    'slug' => 'core-banking-platform',
                    'content' => 'Core Banking Platform page',
                    'meta' => 'core banking platform',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 4,
                    'title' => 'Islamic Banking',
                    'slug' => 'islamic-banking',
                    'content' => 'Islamic Banking page',
                    'meta' => 'islamic banking',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 5,
                    'title' => 'Loan Origination & Approval',
                    'slug' => 'loan-origination-approval',
                    'content' => 'Loan Origination & Approval page',
                    'meta' => 'loan origination approval',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 6,
                    'title' => 'Core Platform for NBFIs',
                    'slug' => 'core-platform-for-nbfis',
                    'content' => 'Core Platform for NBFIs page',
                    'meta' => 'core platform, nbfis',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 7,
                    'title' => 'Microfinance',
                    'slug' => 'microfinance',
                    'content' => 'Microfinance Page',
                    'meta' => 'microfinance',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 8,
                    'title' => 'Agent Banking',
                    'slug' => 'agent-banking',
                    'content' => 'Agent Banking Page',
                    'meta' => 'agent-banking',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 9,
                    'title' => 'Cheque Processing & EFT',
                    'slug' => 'cheque-processing-eft',
                    'content' => 'Cheque Processing & EFT Page',
                    'meta' => 'cheque-processing-eft',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 10,
                    'title' => 'Anti-Money Laundering',
                    'slug' => 'anti-money-laundering',
                    'content' => 'Anti-Money Laundering Page',
                    'meta' => 'anti-money-laundering',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 11,
                    'title' => 'Customer On-boarding & e-KYC',
                    'slug' => 'customer-on-obarding-e-kyc',
                    'content' => 'Customer On-boarding & e-KYC Page',
                    'meta' => 'customer-on-obarding-e-kyc',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 12,
                    'title' => 'Treasury Management',
                    'slug' => 'treasury-management',
                    'content' => 'Treasury Management Page',
                    'meta' => 'treasury-management',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 13,
                    'title' => 'Remittance Management',
                    'slug' => 'remittance-management',
                    'content' => 'Remittance Management Page',
                    'meta' => 'remittance-management',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 14,
                    'title' => 'Internet Banking',
                    'slug' => 'internet-banking',
                    'content' => 'Internet Banking Page',
                    'meta' => 'internet-banking',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 15,
                    'title' => 'E-Tender',
                    'slug' => 'e-tender',
                    'content' => 'E-Tender Page',
                    'meta' => 'e-tender',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 16,
                    'title' => 'ERP',
                    'slug' => 'erp',
                    'content' => 'ERP Page',
                    'meta' => 'erp',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 17,
                    'title' => 'HR Management',
                    'slug' => 'hr-management',
                    'content' => 'HR Management Page',
                    'meta' => 'hr-management',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 18,
                    'title' => 'E-Recruitment',
                    'slug' => 'e-recruitment',
                    'content' => 'E-Recruitment Page',
                    'meta' => 'e-recruitment',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 19,
                    'title' => 'Artificial Intelligence',
                    'slug' => 'artificial-intelligence',
                    'content' => 'Artificial Intelligence Page',
                    'meta' => 'artificial-intelligence',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 20,
                    'title' => 'Internet of Things',
                    'slug' => 'internet-of-things',
                    'content' => 'Internet of Things Page',
                    'meta' => 'internet-of-things',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 21,
                    'title' => 'Mobile Apps',
                    'slug' => 'mobile-apps',
                    'content' => 'Mobile Apps Page',
                    'meta' => 'mobile-apps',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 22,
                    'title' => 'Outsourcing',
                    'slug' => 'outsourcing',
                    'content' => 'Outsourcing Page',
                    'meta' => 'outsourcing',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 23,
                    'title' => 'Services',
                    'slug' => 'services',
                    'content' => 'Services Page',
                    'meta' => 'services',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
                [
                    'id' => 24,
                    'title' => 'Life at ERA',
                    'slug' => 'life-at-era',
                    'content' => 'Life at ERA',
                    'meta' => 'life-at-era',
                    'created_at' => '2021-09-06 05:00:36',
                    'updated_at' => '2021-09-06 05:00:36',
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //DB::table('menu_items')->truncate();
        //DB::table('menus')->truncate();
        //DB::table('pages')->truncate();
        DB::table('company_infos')->truncate();
        DB::table('about_us')->truncate();
        DB::table('users')->truncate();
    }
}
