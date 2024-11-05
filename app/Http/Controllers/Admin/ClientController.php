<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreClientRequest;
use App\Models\Client;
use App\Repositories\ClientRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    /**
     * The client repository instance.
     *
     * @var ClientRepositoryInterface
     */
    private ClientRepositoryInterface $clientRepository;

    /**
     * Creates a new instance of the controller.
     *
     * The constructor injects the client repository instance, which is used to
     * interact with the clients in the repository.
     *
     * @param ClientRepositoryInterface $clientRepository The client repository instance.
     */
    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * Shows the list of clients.
     *
     * This method displays the list of clients stored in the repository,
     * paginated. The clients are retrieved from the repository using the
     * paginate method, and the view is rendered with the list of clients.
     *
     * @return \Illuminate\View\View The view containing the list of clients.
     */
    public function index(): \Illuminate\View\View
    {
        // Retrieve the paginated list of clients from the repository.
        $clients = $this->clientRepository->paginate(15);

        // Render the view with the list of clients.
        return view('admin.clients.index', ['clients' => $clients]);
    }

    /**
     * Stores a new client in the repository.
     *
     * Validates the incoming request using the ClientRequest and stores a new
     * client record using the client repository. Returns a JSON response with a
     * success message and the created client data.
     *
     * @param StoreClientRequest $request The request instance containing the
     *                                    validated client data.
     *
     * @return JsonResponse A JSON response containing a success message and the
     *                      created client data.
     */
    public function store(StoreClientRequest $request): JsonResponse
    {
        try {
            $createdClient = $this->clientRepository->create($request->validated());

            return response()->json([
                'message' => 'Cliente cadastrado com sucesso! Aguarde a pagina recarregar.',
                'client' => $createdClient,
            ], Response::HTTP_CREATED);

        } catch (QueryException $queryException) {
            return response()->json([
                'message' => 'Falha ao cadastrar o cliente. Verifique os dados fornecidos.',
                'error' => $queryException->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (Throwable $throwable) {
            return response()->json([
                'message' => 'Ocorreu um erro inesperado ao cadastrar o cliente.',
                'error' => $throwable->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update()
    {

    }

	public function destroy(): 
    {

    }
}