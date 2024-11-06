<?php

namespace App\Providers;

use Faker\Provider\Base as BaseProvider;

class BrazilianPhoneNumberProvider extends BaseProvider
{
    /**
     * Generate a random Brazilian phone number.
     *
     * The phone number is formatted like (xx) 9xxxx-xxxx.
     *
     * @return string
     */
    public function brazilianPhoneNumber(): string
    {
        return $this->generator->numerify('(##) 9####-####');
    }
}
