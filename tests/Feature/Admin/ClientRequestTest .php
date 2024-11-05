<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests the creation of a new client with a valid CPF.
     *
     * This test creates a new client with a valid CPF and checks if the
     * response is 201 Created, indicating that the client was created
     * successfully.
     */
    public function test_client_creation_with_valid_cpf(): void
    {
        $cpf = faker()->cpf();

        $response = $this->postJson('/api/clients', [
            'cpfcnpj' => $cpf,
            'name' => 'Test Client',
            'email' => 'test@example.com',
            'phone' => '1234567890',
        ]);

        $response->assertStatus(201);
    }

    /**
     * Tests the creation of a new client with a valid CNPJ.
     *
     * This test creates a new client with a valid CNPJ and checks if the
     * response is 201 Created, indicating that the client was created
     * successfully.
     */
    public function test_client_creation_with_valid_cnpj(): void
    {
        $cnpj = faker()->cnpj();

        $response = $this->postJson('/api/clients', [
            'cpfcnpj' => $cnpj,
            'name' => 'Test Client',
            'email' => 'test2@example.com',
            'phone' => '1234567890',
        ]);

        $response->assertStatus(201);
    }

    /**
     * Tests the creation of a new client with an invalid CPF/CNPJ.
     *
     * This test attempts to create a new client using an invalid CPF/CNPJ
     * and expects a 422 Unprocessable Entity response, indicating that
     * the validation failed for the CPF/CNPJ field.
     */
    public function test_client_creation_with_invalid_cpfcnpj(): void
    {
        $response = $this->postJson('/api/clients', [
            'cpfcnpj' => '12345678900',
            'cpfcnpj' => '12345678900',
            'name' => 'Test Client',
            'email' => 'test3@example.com',
            'phone' => '1234567890',
        ]);

        $response->assertStatus(422);
        
        $response->assertJsonValidationErrors(['cpfcnpj']);
    }
}
