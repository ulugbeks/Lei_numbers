<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    $homePage = [
        'name' => 'Home',
        'slug' => 'home',
        'content' => json_encode([
            'banner' => [
                'title' => 'Apply for an LEI number',
                'description' => 'Agilos helps you to convert your data into a strategic asset and get top-notch business insights.',
                'button_text' => 'What is LEI',
                'button_url' => '/about-lei',
                'background_image' => 'assets/img/banner/h2_banner_bg.jpg',
                'main_image' => 'assets/img/banner/h2_banner_img.png'
            ]
        ]),
        'status' => true,
        'created_at' => now(),
        'updated_at' => now()
    ];

    DB::table('pages')->insert($homePage);

    // Добавим и другие страницы
    $pages = [
        [
            'name' => 'What is LEI',
            'slug' => 'about-lei',
            'content' => json_encode([]),
            'status' => true,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'About Us',
            'slug' => 'about',
            'content' => json_encode([]),
            'status' => true,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Contact',
            'slug' => 'contact',
            'content' => json_encode([]),
            'status' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]
    ];

    DB::table('pages')->insert($pages);
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
