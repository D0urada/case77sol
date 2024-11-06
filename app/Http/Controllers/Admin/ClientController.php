<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreClientRequest;
use App\Http\Requests\Admin\UpdateClientRequest;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Repositories\ClientRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Throwable;

class ClientController extends Controller
{
	/**
     * The client repository instance.
     *
     * @var ClientRepositoryInterface
     */
	private ClientRepositoryInterface $clientRepository;

    /**
     * Constructor method.
     *
     * This method initializes the client repository instance.
     *
     * @param ClientRepositoryInterface $clientRepository The client repository instance.
     */
    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * This method handles the incoming request to list all clients.
     * It uses the client repository to retrieve a paginated list of clients
     * and renders the clients list view with the clients data.
     *
     * @return \Illuminate\View\View The clients list view with the clients data.
     */
    public function index(): \Illuminate\View\View
    {
        // Retrieve a paginated list of clients using the client repository
        $clients = $this->clientRepository->paginate(15);

        // Render the clients list view with the clients data
        return view('admin.clients.index', compact('clients'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * This method handles the incoming request to store a client.
     * It uses the client repository to create a new client and
     * returns a JSON response with the created client data.
     * If the client creation fails, it returns a JSON response
     * with an error message and the appropriate HTTP status code.
     *
     * @param StoreClientRequest $request The validated request data.
     * @return JsonResponse The JSON response with the created client data or error message.
     */
    public function store(StoreClientRequest $request): JsonResponse
    {
        try {
            // Create the client using the client repository
            $client = $this->clientRepository->create($request->validated());

            // Return a JSON response with the created client data
            return response()->json([
                'message' => 'Cliente cadastrado com sucesso!',
                'client' => $client,
            ], Response::HTTP_CREATED);

        } catch (Throwable $e) {
            // Handle the exception and return a JSON response with an error message
            $statusCode = $e instanceof \Illuminate\Database\QueryException
                ? Response::HTTP_UNPROCESSABLE_ENTITY
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            return response()->json([
                'message' => 'Erro ao cadastrar o cliente.',
                'error' => $e->getMessage(),
            ], $statusCode);
        }
    }


    /**
     * Display the specified client in a form for editing.
     *
     * This method handles the incoming request to edit a client.
     * It uses the client repository to retrieve the client data
     * and renders the clients edit view with the client data.
     * If the client is not found, it redirects to the clients list
     * route with an error message.
     *
     * @param int $clientId The client ID to be edited.
     * @return \Illuminate\View\View The clients edit view with the client data.
     */
    public function show(int $clientId): \Illuminate\View\View
    {
        $client = $this->clientRepository->findById($clientId);

        if (!$client) {
            // Return a JSON response with an error message
            return response()->json([
                'message' => 'Cliente n o encontrado.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Render the clients edit view with the client data
        return view('admin.clients.show', compact('client'));
    }


    /**
     * Update the specified client in storage.
     *
     * @param UpdateClientRequest $request The validated request data.
     * @param Client $client The client instance to be updated.
     * @return JsonResponse The JSON response indicating success or failure.
     */
    public function update(UpdateClientRequest $request, Client $client): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            // Retrieve the client instance from the client repository
            $existingClient = $this->clientRepository->findById($client->id);

            if (!$existingClient) {
                // Return a JSON response with an error message
                return response()->json([
                    'message' => 'Cliente n o encontrado.',
                ], Response::HTTP_NOT_FOUND);
            }

            // Update the client using the client repository
            $updatedClient = $this->clientRepository->update($validatedData, $client);

            // Return a JSON response with the updated client data
            return response()->json([
                'message' => 'Cliente atualizado com sucesso!',
                'client' => $updatedClient,
            ], Response::HTTP_OK);

        } catch (Throwable $exception) {
            // Handle the exception and return a JSON response with an error message
            $statusCode = $exception instanceof \Illuminate\Database\QueryException
                ? Response::HTTP_UNPROCESSABLE_ENTITY
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            return response()->json([
                'message' => 'Erro ao editar o cliente.',
                'error' => $exception->getMessage(),
            ], $statusCode);
        }
    }


    /**
     * Remove the specified client from storage.
     *
     * This method handles the incoming request to delete a client.
     * It attempts to delete the client using the client repository.
     * If the client is not found, it redirects to the clients list route
     * with an error message. If the deletion fails, it returns a JSON response
     * with an error message and the appropriate HTTP status code.
     *
     * @param int $clientId The client ID to be deleted.
     * @return \Illuminate\Http\RedirectResponse The redirect response to the clients list route.
     */
    public function destroy(int $clientId): \Illuminate\Http\RedirectResponse
    {
        try {
            $client = $this->clientRepository->findById($clientId);

            if (!$client) {
                return redirect()->route('admin.clients.index')
                    ->with('error', 'Cliente não encontrado.');
            }

            $this->clientRepository->delete($client);

            return redirect()->route('admin.clients.index')
                ->with('success', 'Cliente excluido com sucesso!');

        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Erro ao remover o cliente.',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
