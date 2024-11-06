<?php

namespace App\Providers;

use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Illuminate\Support\ServiceProvider;
use App\Providers\BrazilianDocumentsProvider;
use App\Providers\BrazilianPhoneNumberProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FakerGenerator::class, function () {
            $faker = FakerFactory::create();

            $faker->addProvider(new BrazilianDocumentsProvider($faker));
            $faker->addProvider(new BrazilianPhoneNumberProvider($faker));

            return $faker;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
