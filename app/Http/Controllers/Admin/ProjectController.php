<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\UfRepositoryInterface;
use App\Repositories\Interfaces\EquipmentRepositoryInterface;
use App\Repositories\Interfaces\InstallationTypeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Project;
use Illuminate\View\View;
use Throwable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    /**
     * The project repository instance.
     *
     * @var ProjectRepositoryInterface
     */
    private ProjectRepositoryInterface $projectRepository;

    /**
     * The uf repository instance.
     *
     * @var UfRepositoryInterface
     */
    protected UfRepositoryInterface $ufRepository;

    /**
     * The equipment repository instance.
     *
     * @var EquipmentRepositoryInterface
     */
    protected EquipmentRepositoryInterface $equipmentRepository;

    /**
     * The installation type repository instance.
     *
     * @var InstallationTypeRepositoryInterface
     */
    protected InstallationTypeRepositoryInterface $installationTypeRepository;

    /**
     * Create a new controller instance.
     *
     * @param ProjectRepositoryInterface $projectRepository
     * @param UfRepositoryInterface $ufRepository
     * @param EquipmentRepositoryInterface $equipmentRepository
     * @param InstallationTypeRepositoryInterface $installationTypeRepository
     */
    public function __construct(
        ProjectRepositoryInterface $projectRepository,
        UfRepositoryInterface $ufRepository,
        EquipmentRepositoryInterface $equipmentRepository,
        InstallationTypeRepositoryInterface $installationTypeRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->ufRepository = $ufRepository;
        $this->equipmentRepository = $equipmentRepository;
        $this->installationTypeRepository = $installationTypeRepository;
    }

    /**
     * Display a listing of the projects.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $projects = !is_null($request->search)
            ? $this->projectRepository->search($request->search, 15)
            : $this->projectRepository->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     *
     * This function retrieves all necessary data for creating a project, including clients, UFs,
     * equipment, and installation types, and then returns the view for project creation.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        // Retrieve all clients
        $clients = $this->projectRepository->all();

        // Retrieve all UFs
        $ufList = $this->ufRepository->all();

        // Retrieve all equipment
        $equipmentList = $this->equipmentRepository->all();

        // Retrieve all installation types
        $installationTypeList = $this->installationTypeRepository->all();

        // Return the view with the data needed to create a project
        return view('admin.projects.create', compact('clients', 'ufList', 'equipmentList', 'installationTypeList'));
    }

    public function store(StoreProjectRequest $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'client_id' => $request->client_id,
                'installation_type' => $request->installation_type,
                'location_uf' => $request->location_uf,
                'equipment' => $request->equipment,
            ];

            $project = $this->projectRepository->create($data);

            // Retorna a resposta com o projeto criado
            return response()->json([
                'message' => 'Projeto cadastrado com sucesso!',
                'project' => $project,
            ], Response::HTTP_CREATED);

        } catch (Throwable $e) {
            // Handle the exception and return a JSON response with an error message
            $statusCode = $e instanceof QueryException
                ? Response::HTTP_UNPROCESSABLE_ENTITY
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            return response()->json([
                'message' => 'Erro ao cadastrar o projeto.',
                'error' => $e->getMessage(),
            ], $statusCode);
        }
    }

    /**
     * Display the specified project.
     *
     * This method handles the incoming request to show a project.
     * It uses the project repository to retrieve the project data
     * and renders the projects show view with the project data.
     * If the project is not found, it returns a JSON response with an error message.
     *
     * @param int $projectId The project ID to retrieve.
     *
     * @return View The projects show view with the project data.
     */
    public function show(int $projectId): View
    {
        $project = $this->projectRepository->findById($projectId);

        // Retrieve all clients
        $clients = $this->projectRepository->all();

        // Retrieve all UFs
        $ufList = $this->ufRepository->all();

        // Retrieve all equipment
        $equipmentList = $this->equipmentRepository->all();

        // Retrieve all installation types
        $installationTypeList = $this->installationTypeRepository->all();

        $initialEquipmentList = json_encode($project->equipment);

        if (!$project) {
            // Return a JSON response with an error message
            return response()->json([
                'message' => 'Projeto não encontrado.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Render the projects show view with the project data
        return view('admin.projects.show', compact('project', 'clients', 'ufList', 'equipmentList', 'initialEquipmentList', 'installationTypeList'));
    }


    public function update(Request $request, Project $project): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $existingProject = $this->projectRepository->findById($project->id);

            if (!$existingProject) {
                return response()->json([
                    'message' => 'Projeto não foi encontrado.',
                ], Response::HTTP_NOT_FOUND);
            }

            $updatedProject = $this->projectRepository->update($validatedData, $project);

            return response()->json([
                'message' => 'Projeto atualizado com sucesso!',
                'project' => $updatedProject,
            ], Response::HTTP_OK);

        } catch (Throwable $exception) {
            $statusCode = $exception instanceof QueryException
                ? Response::HTTP_UNPROCESSABLE_ENTITY
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            return response()->json([
                'message' => 'Erro ao editar o projeto.',
                'error' => $exception->getMessage(),
            ], $statusCode);
        }
    }

    /**
     * Remove the specified project from storage.
     *
     * This method handles the incoming request to delete a project.
     * It attempts to delete the project using the project repository.
     * If the project is not found, it redirects to the projects list route
     * with an error message. If the deletion fails, it returns a JSON response
     * with an error message and the appropriate HTTP status code.
     *
     * @param int $projectId The project ID to delete.
     *
     * @return RedirectResponse The redirect response with a success or error message.
     */
    public function destroy(int $projectId): RedirectResponse
    {
        try {
            // Retrieve the project instance from the project repository
            $project = $this->projectRepository->findById($projectId);

            if (!$project) {
                // Return a redirect response with an error message
                return redirect()->route('admin.projects.index')
                    ->with('error', 'Projeto não encontrado.');
            }

            // Delete the project using the project repository
            $this->projectRepository->delete($project);

            // Return a redirect response with a success message
            return redirect()->route('admin.projects.index')
                ->with('success', 'Projeto excluido com sucesso!');

        } catch (Throwable $exception) {
            // Handle the exception and return a JSON response with an error message
            return response()->json([
                'message' => 'Erro ao remover o projeto.',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
