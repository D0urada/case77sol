<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreClientRequest;
use App\Http\Requests\Admin\UpdateClientRequest;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Throwable;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Database\QueryException;

class ClientController extends Controller
{
	/**
     * The client repository instance.
     *
     * @var ClientRepositoryInterface
     */
	private ClientRepositoryInterface $clientRepository;

    /**
     * Create a new controller instance.
     *
     * This method creates a new controller instance and injects the client
     * repository instance through the constructor.
     *
     * @param ClientRepositoryInterface $clientRepository The client repository instance.
     */
    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * Display a listing of the clients.
     *
     * This method handles the incoming request to list all clients.
     * It uses the client repository to retrieve the clients data
     * and renders the clients list view with the clients data.
     * If the client has searched for a specific client, it uses
     * the client repository to retrieve the search results.
     *
     * @param Request $request The incoming HTTP request.
     * @return View The clients list view with the clients data.
     */
    public function index(Request $request): View
    {
        $clients = !is_null($request->search)
            // Retrieve the clients that match the search query
            ? $this->clientRepository->search($request->search)->paginate(15)
            // Retrieve all clients
            : $this->clientRepository->paginate(15);

        // Render the clients list view with the clients data
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Store a newly created client in the database.
     *
     * This method handles the incoming request to store a client.
     * It validates the request data using the StoreClientRequest and
     * uses the client repository to create the client.
     * If the creation is successful, it returns a JSON response with the
     * created client data and the HTTP status code 201.
     * If the creation fails, it returns a JSON response with an error
     * message and the appropriate HTTP status code.
     *
     * @param StoreClientRequest $request The validated request data.
     *
     * @return JsonResponse The JSON response with the created client data or an error message.
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
     * Display the specified client.
     *
     * This method handles the incoming request to show a client.
     * It uses the client repository to retrieve the client data
     * and renders the clients show view with the client data.
     * If the client is not found, it returns a JSON response with an error message.
     *
     * @param int $clientId The client ID to retrieve.
     *
     * @return View The clients show view with the client data.
     */
    public function show(int $clientId): View
    {
        $client = $this->clientRepository->findById($clientId);

        if (!$client) {
            // Return a JSON response with an error message
            return response()->json([
                'message' => 'Cliente n o encontrado.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Render the clients show view with the client data
        return view('admin.clients.show', compact('client'));
    }

    /**
     * Update the specified client in storage.
     *
     * This method handles the incoming request to update a client.
     * It attempts to update the client using the client repository.
     * If the client is not found, it redirects to the clients list route
     * with an error message. If the update fails, it returns a JSON response
     * with an error message and the appropriate HTTP status code.
     *
     * @param UpdateClientRequest $request The request instance containing the validated client data.
     * @param Client $client The client instance to be updated.
     *
     * @return JsonResponse The JSON response with the updated client data.
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
            $statusCode = $exception instanceof QueryException
                ? Response::HTTP_UNPROCESSABLE_ENTITY
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            return response()->json([
                'message' => 'Erro ao editar o cliente.',
                'error' => $exception->getMessage(),
            ], $statusCode);
        }
    }

    /**
     * Remove the specified client from the database.
     *
     * This method handles the incoming request to delete a client.
     * It attempts to delete the client using the client repository.
     * If the client is not found, it redirects to the clients list route
     * with an error message. If the deletion fails, it returns a JSON response
     * with an error message and the appropriate HTTP status code.
     *
     * @param int $clientId The client ID to delete.
     *
     * @return RedirectResponse The redirect response with a success or error message.
     */
    public function destroy(int $clientId): RedirectResponse
    {
        try {
            // Retrieve the client instance from the client repository
            $client = $this->clientRepository->findById($clientId);

            if (!$client) {
                // Return a redirect response with an error message
                return redirect()->route('admin.clients.index')
                    ->with('error', 'Cliente n o encontrado.');
            }

            // Delete the client using the client repository
            $this->clientRepository->delete($client);

            // Return a redirect response with a success message
            return redirect()->route('admin.clients.index')
                ->with('success', 'Cliente exclu do com sucesso!');

        } catch (Throwable $exception) {
            // Handle the exception and return a JSON response with an error message
            return response()->json([
                'message' => 'Erro ao remover o cliente.',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Handle the incoming request to search for a client.
     *
     * This method receives the search query from the request and
     * uses the client repository to search for a client with the
     * given query. If the client is not found, it returns a JSON
     * response with a 404 status code and an error message. If the
     * search fails, it returns a JSON response with a 500 status
     * code and an error message.
     *
     * @param Request $request The request containing the search query.
     *
     * @return JsonResponse The JSON response with the search results or an error message.
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = $request->input('q');

            if (empty($query)) {
                return response()->json([
                    'message' => 'Preencha o campo de busca.',
                ], Response::HTTP_BAD_REQUEST);
            }

            $clients = $this->clientRepository->search($query)->get();

            if (!$clients) {
                return response()->json([
                    'message' => 'Nenhum cliente encontrado.',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($clients);

        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Erro ao procurar o cliente.',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
