<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use App\Providers\BrazilianDocumentsProvider;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected FakerGenerator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        // Configure Faker and add the Brazilian provider for CPF/CNPJ
        $this->faker = FakerFactory::create();
        $this->faker->addProvider(new BrazilianDocumentsProvider($this->faker));
    }
}
