<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use SEO;

class SEOServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Настройка глобальных SEO-параметров
        SEO::setTitle('Home page')
            ->setDescription('Description of the project')
            ->setCanonical(url('/'))
            ->addImages(['https://example.com/image.jpg']);

        // Настройка Open Graph
        SEO::opengraph()->setType('website')
            ->setTitle('My project')
            ->setDescription('Description of the project')
            ->setUrl(url('/'))
            ->setSiteName('Name of the website');

        // Настройка Twitter Cards
        SEO::twitter()->setSite('@username');
    }
}