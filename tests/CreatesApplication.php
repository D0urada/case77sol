<?php

namespace Tests;

trait CreatesApplication
{
    /**
     * Cria a aplicação de teste.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
