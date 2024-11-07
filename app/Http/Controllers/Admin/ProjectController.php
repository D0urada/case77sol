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
     * @OA\Get(
     *     path="/admin/projects",
     *     tags={"Projects"},
     *     summary="List all projects",
     *     description="Retrieve a paginated list of all projects",
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         description="Search term for filtering projects",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of projects",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Project"))
     *     )
     * )
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
     * @OA\Get(
     *     path="/admin/projects/create",
     *     tags={"Projects"},
     *     summary="Show project creation form",
     *     description="Displays the form for creating a new project",
     *     @OA\Response(
     *         response=200,
     *         description="Project creation form",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     )
     * )
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

    /**
     * Store a newly created project in the database.
     *
     * @OA\Post(
     *     path="/admin/projects",
     *     tags={"Projects"},
     *     summary="Create a new project",
     *     description="Stores a new project in the database",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreProjectRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Project created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        try {
            // Prepare the data array from the request
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'client_id' => $request->client_id,
                'installation_type' => $request->installation_type,
                'location_uf' => $request->location_uf,
                'equipment' => $request->equipment,
            ];

            // Create the project using the project repository
            $project = $this->projectRepository->create($data);

            // Return a JSON response with the created project data
            return response()->json([
                'message' => 'Projeto cadastrado com sucesso!',
                'project' => $project,
            ], Response::HTTP_CREATED);

        } catch (Throwable $e) {
            // Determine the appropriate status code based on the exception type
            $statusCode = $e instanceof QueryException
                ? Response::HTTP_UNPROCESSABLE_ENTITY
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            // Handle the exception and return a JSON response with an error message
            return response()->json([
                'message' => 'Erro ao cadastrar o projeto.',
                'error' => $e->getMessage(),
            ], $statusCode);
        }
    }

    /**
     * Display the specified project.
     *
     * @OA\Get(
     *     path="/admin/projects/{projectId}",
     *     tags={"Projects"},
     *     summary="Show project details",
     *     description="Displays details of the specified project",
     *     @OA\Parameter(
     *         name="projectId",
     *         in="path",
     *         required=true,
     *         description="ID of the project to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project details",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
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

    /**
     * Update the specified project in the database.
     *
     * @OA\Put(
     *     path="/admin/projects/{projectId}",
     *     tags={"Projects"},
     *     summary="Update an existing project",
     *     description="Updates an existing project",
     *     @OA\Parameter(
     *         name="projectId",
     *         in="path",
     *         required=true,
     *         description="ID of the project to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateProjectRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function update(Request $request, Project $project): JsonResponse
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validated();

            // Retrieve the existing project from the repository
            $existingProject = $this->projectRepository->findById($project->id);

            if (!$existingProject) {
                // Return a JSON response with an error message if the project is not found
                return response()->json([
                    'message' => 'Projeto não foi encontrado.',
                ], Response::HTTP_NOT_FOUND);
            }

            // Update the project using the validated data
            $updatedProject = $this->projectRepository->update($validatedData, $project);

            // Return a JSON response with the updated project data
            return response()->json([
                'message' => 'Projeto atualizado com sucesso!',
                'project' => $updatedProject,
            ], Response::HTTP_OK);

        } catch (Throwable $exception) {
            // Determine the appropriate status code based on the exception type
            $statusCode = $exception instanceof QueryException
                ? Response::HTTP_UNPROCESSABLE_ENTITY
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            // Handle the exception and return a JSON response with an error message
            return response()->json([
                'message' => 'Erro ao editar o projeto.',
                'error' => $exception->getMessage(),
            ], $statusCode);
        }
    }

    /**
     * Remove the specified project from storage.
     *
     * @OA\Delete(
     *     path="/admin/projects/{projectId}",
     *     tags={"Projects"},
     *     summary="Delete a project",
     *     description="Deletes a project from the database",
     *     @OA\Parameter(
     *         name="projectId",
     *         in="path",
     *         required=true,
     *         description="ID of the project to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
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
