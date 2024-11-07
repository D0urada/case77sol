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

/**
 * @OA\PathItem(
 *     path="/admin/clients",
 *     description="Endpoints relacionados ao cliente"
 * )
 */
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
     * List all clients.
     *
     * This method lists all clients in the database, with optional search
     * query to filter the results. The results are paginated and can be
     * directly passed to the view.
     *
     * @param Request $request The incoming request.
     *
     * @return View The clients list view with the clients data.
     */
    public function index(Request $request): View
    {
        // Retrieve the clients that match the search query
        $clients = !is_null($request->search)
            // Search for clients using the client repository
            ? $this->clientRepository->search($request->search)->paginate(15)
            // Retrieve all clients using the client repository
            : $this->clientRepository->paginate(15);

        // Render the clients list view with the clients data
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * @OA\Post(
     *     path="/admin/clients",
     *     summary="Cria um novo cliente",
     *     description="Cria um cliente e retorna os detalhes do cliente criado.",
     *     tags={"Client"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="João Silva"),
     *             @OA\Property(property="email", type="string", example="joao@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente criado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação ao criar cliente"
     *     )
     * )
     *
     * Store a newly created client in storage.
     *
     * This method handles the creation of a new client by validating
     * the request data, storing the client using the repository, and
     * returning a JSON response with the created client details.
     *
     * @param StoreClientRequest $request The request instance containing client data.
     *
     * @return JsonResponse The JSON response with client creation status.
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
            // Determine the status code based on the exception type
            $statusCode = $e instanceof \Illuminate\Database\QueryException
                ? Response::HTTP_UNPROCESSABLE_ENTITY
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            // Return a JSON response with an error message
            return response()->json([
                'message' => 'Erro ao cadastrar o cliente.',
                'error' => $e->getMessage(),
            ], $statusCode);
        }
    }

    /**
     * @OA\Get(
     *     path="/admin/clients/{clientId}",
     *     summary="Mostra um cliente existente",
     *     description="Mostra os dados de um cliente pelo ID.",
     *     tags={"Client"},
     *     @OA\Parameter(
     *         name="clientId",
     *         in="path",
     *         required=true,
     *         description="ID do cliente a ser mostrado",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Client")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente não encontrado"
     *     )
     * )
     *
     * @param int $clientId The ID of the client to show.
     *
     * @return View The clients show view with the client data.
     */
    public function show(int $clientId): View
    {
        // Retrieve the client by ID using the client repository
        $client = $this->clientRepository->findById($clientId);

        if (!$client) {
            // Return a JSON response with an error message if the client is not found
            return response()->json([
                'message' => 'Cliente n o encontrado.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Render the clients show view with the client data
        return view('admin.clients.show', compact('client'));
    }

    /**
     * @OA\Put(
     *     path="/admin/clients/{clientId}",
     *     summary="Atualiza um cliente existente",
     *     description="Atualiza os dados de um cliente pelo ID.",
     *     tags={"Client"},
     *     @OA\Parameter(
     *         name="clientId",
     *         in="path",
     *         required=true,
     *         description="ID do cliente a ser atualizado",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Jo o Silva Atualizado"),
     *             @OA\Property(property="email", type="string", example="joao_atualizado@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente n o encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de valida o ao atualizar cliente"
     *     )
     * )
     */
    /**
     * Update a client by ID.
     *
     * This method updates a client by its ID. If the client is not found,
     * it returns a JSON response with an error message. If the update
     * fails, it returns a JSON response with an error message.
     *
     * @param UpdateClientRequest $request The request instance containing the update data.
     * @param Client $client The client instance to be updated.
     *
     * @return JsonResponse The JSON response with the updated client data or an error message.
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
     * @OA\Delete(
     *     path="/admin/clients/{clientId}",
     *     tags={"Clients"},
     *     summary="Delete a client by ID",
     *     description="Deletes a client by its ID. If the client is not found, returns an error message. If the deletion fails, returns an error message.",
     *     @OA\Parameter(
     *         name="clientId",
     *         in="path",
     *         required=true,
     *         description="ID of the client to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Client successfully deleted",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Cliente excluído com sucesso!"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Cliente não encontrado."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Erro ao remover o cliente."
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Exception message here"
     *             )
     *         )
     *     )
     * )
     * Deletes a client by ID.
     *
     * This method deletes a client by its ID. If the client is not found,
     * it returns a redirect response with an error message. If the deletion
     * fails, it returns a redirect response with an error message.
     *
     * @param int $clientId The ID of the client to delete.
     *
     * @return RedirectResponse The redirect response with a success or error message.
     */
    public function destroy(int $clientId): RedirectResponse
    {
        try {
            // Retrieve the client instance from the client repository
            $client = $this->clientRepository->findById($clientId);

            if (!$client) {
                // Return a redirect response with an error message if the client is not found
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
     * @OA\Get(
     *     path="/admin/clients/search",
     *     tags={"Clients"},
     *     summary="Search for clients by query string",
     *     description="Searches for clients based on a query string. Returns a JSON response containing the found clients.",
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         required=true,
     *         description="Query string to search clients",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Found clients",
     *         @OA\JsonContent(
     *             type="array",
     *             items=@OA\Items(ref="#/components/schemas/Client")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request: Query string is empty",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Preencha o campo de busca."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No clients found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Nenhum cliente encontrado."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Erro ao procurar o cliente."
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Exception message here"
     *             )
     *         )
     *     )
     * )
     * Searches for clients based on a query string.
     *
     * This method returns a JSON response containing the found clients.
     *
     * @param Request $request The request instance containing the query string.
     *
     * @return JsonResponse The JSON response containing the found clients.
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = $request->input('q');

            // Validate the query string
            if (empty($query)) {
                return response()->json([
                    'message' => 'Preencha o campo de busca.',
                ], Response::HTTP_BAD_REQUEST);
            }

            // Search for clients using the client repository
            $clients = $this->clientRepository->search($query)->get();

            // Handle the case where no clients were found
            if (!$clients) {
                return response()->json([
                    'message' => 'Nenhum cliente encontrado.',
                ], Response::HTTP_NOT_FOUND);
            }

            // Return the found clients as a JSON response
            return response()->json($clients);

        } catch (Throwable $exception) {
            // Handle the exception and return a JSON response with an error message
            return response()->json([
                'message' => 'Erro ao procurar o cliente.',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
