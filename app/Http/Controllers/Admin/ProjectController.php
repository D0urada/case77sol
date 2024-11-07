<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreProjectRequest;
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


    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }


    public function edit(Project $project)
    {
        $clients = Client::all();
        return view('admin.projects.edit', compact('project', 'clients'));
    }


    public function update(Request $request, Project $project)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'uf' => 'required',
            'installation_type' => 'required',
        ]);

        $this->projectRepository->update($project, $request->all());

        return redirect()->route('projects.index');
    }


    public function destroy(Project $project)
    {
        $this->projectRepository->delete($project);

        return redirect()->route('projects.index');
    }

}
