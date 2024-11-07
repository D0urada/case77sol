<?php

use Tests\TestCase;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Requests\Admin\StoreClientRequest;
use App\Repositories\ClientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Mockery\MockInterface;
use App\Providers\BrazilianDocumentsProvider;

class ClientControllerTest extends TestCase
{
    private $clientController;
    private $clientRepository;

    public function setUp(): void
    {
        parent::setUp();

        // Criando mocks e adicionando o nome para cada um
        $this->clientRepository = Mockery::mock(ClientRepository::class)->named('ClientRepository');
        $this->clientController = new ClientController($this->clientRepository);
    }

    public function testSuccessfulClientCreation()
    {
        // Mockando o BrazilianDocumentsProvider
        $documentsProvider = Mockery::mock(BrazilianDocumentsProvider::class);

        // Criando o StoreClientRequest com a dependência mockada
        $request = new StoreClientRequest($documentsProvider);
        $request->merge(['name' => 'John Doe', 'email' => 'john@example.com']);

        // Criando o cliente esperado
        $client = new \App\Models\Client();
        $client->name = 'John Doe';
        $client->email = 'john@example.com';

        // Configurando o mock para retornar o cliente
        $this->clientRepository->shouldReceive('create')->andReturn($client);

        // Chamando o método do controller
        $response = $this->clientController->store($request);

        // Validando a resposta
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals(['message' => 'Cliente cadastrado com sucesso!', 'client' => $client], $response->getData());
    }

    public function testClientCreationFailsDueToDatabaseQueryException()
    {
        // Mockando o BrazilianDocumentsProvider
        $documentsProvider = Mockery::mock(BrazilianDocumentsProvider::class);

        // Criando o StoreClientRequest com a dependência mockada
        $request = new StoreClientRequest($documentsProvider);
        $request->merge(['name' => 'John Doe', 'email' => 'john@example.com']);

        // Configurando o mock para lançar uma exceção de banco de dados
        $this->clientRepository->shouldReceive('create')->andThrow(new \Illuminate\Database\QueryException());

        // Chamando o método do controller
        $response = $this->clientController->store($request);

        // Validando a resposta
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertEquals(['message' => 'Erro ao cadastrar o cliente.', 'error' => ''], $response->getData());
    }

    public function testClientCreationFailsDueToInternalServerError()
    {
        // Mockando o BrazilianDocumentsProvider
        $documentsProvider = Mockery::mock(BrazilianDocumentsProvider::class);

        // Criando o StoreClientRequest com a dependência mockada
        $request = new StoreClientRequest($documentsProvider);
        $request->merge(['name' => 'John Doe', 'email' => 'john@example.com']);

        // Configurando o mock para lançar uma exceção genérica
        $this->clientRepository->shouldReceive('create')->andThrow(new \Exception());

        // Chamando o método do controller
        $response = $this->clientController->store($request);

        // Validando a resposta
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $this->assertEquals(['message' => 'Erro ao cadastrar o cliente.', 'error' => ''], $response->getData());
    }


    public function testSuccessfulUpdate()
    {
        $request = new UpdateClientRequest();
        $request->validated = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $client = new Client();
        $client->id = 1;
        $this->clientRepository->shouldReceive('findById')->andReturn($client);
        $this->clientRepository->shouldReceive('update')->andReturn($client);
        $response = $this->clientController->update($request, $client);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('Cliente atualizado com sucesso!', $response->getData()->message);
    }
    public function testUpdateNonExistentClient()
    {
        $request = new UpdateClientRequest();
        $request->validated = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $client = new Client();
        $client->id = 1;
        $this->clientRepository->shouldReceive('findById')->andReturn(null);
        $response = $this->clientController->update($request, $client);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEquals('Cliente n o encontrado.', $response->getData()->message);
    }
    public function testUpdateWithQueryException()
    {
        $request = new UpdateClientRequest();
        $request->validated = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $client = new Client();
        $client->id = 1;
        $this->clientRepository->shouldReceive('findById')->andReturn($client);
        $this->clientRepository->shouldReceive('update')->andThrow(new QueryException());
        $response = $this->clientController->update($request, $client);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertEquals('Erro ao editar o cliente.', $response->getData()->message);
    }
    public function testUpdateWithThrowableException()
    {
        $request = new UpdateClientRequest();
        $request->validated = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $client = new Client();
        $client->id = 1;
        $this->clientRepository->shouldReceive('findById')->andReturn($client);
        $this->clientRepository->shouldReceive('update')->andThrow(new Exception());
        $response = $this->clientController->update($request, $client);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $this->assertEquals('Erro ao editar o cliente.', $response->getData()->message);
    }

    public function testDestroyClientSuccess()
    {
        $clientRepository = Mockery::mock(ClientRepository::class);
        $clientRepository->shouldReceive('findById')->andReturn(new Client());
        $clientRepository->shouldReceive('delete')->andReturn(true);
        $clientController = new ClientController($clientRepository);
        $response = $clientController->destroy(1);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('admin.clients.index', $response->getTargetUrl());
        $this->assertEquals('Cliente exclu do com sucesso!', session('success'));
    }
    public function testDestroyClientNotFound()
    {
        $clientRepository = Mockery::mock(ClientRepository::class);
        $clientRepository->shouldReceive('findById')->andReturn(null);
        $clientController = new ClientController($clientRepository);
        $response = $clientController->destroy(1);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('admin.clients.index', $response->getTargetUrl());
        $this->assertEquals('Cliente n o encontrado.', session('error'));
    }
    public function testDestroyClientException()
    {
        $clientRepository = Mockery::mock(ClientRepository::class);
        $clientRepository->shouldReceive('findById')->andReturn(new Client());
        $clientRepository->shouldReceive('delete')->andThrow(new Exception('Test exception'));
        $clientController = new ClientController($clientRepository);
        $response = $clientController->destroy(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('Erro ao remover o cliente.', $response->getData()->message);
        $this->assertEquals('Test exception', $response->getData()->error);
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
}
