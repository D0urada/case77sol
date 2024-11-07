<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * The project repository instance.
     *
     * @var ProjectRepositoryInterface
     */
    private ProjectRepositoryInterface $projectRepository;

    /**
     * Create a new controller instance.
     *
     * @param ProjectRepositoryInterface $projectRepository
     */
    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
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
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $clients = Client::all();
        return view('admin.projects.create', compact('clients'));
    }

    /**
     * Store a newly created project in the database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'uf' => 'required',
            'installation_type' => 'required',
        ]);

        $this->projectRepository->create($request->all());

        return redirect()->route('projects.index');
    }

    /**
     * Display the specified project.
     *
     * @param Project $project
     * @return \Illuminate\View\View
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param Project $project
     * @return \Illuminate\View\View
     */
    public function edit(Project $project)
    {
        $clients = Client::all();
        return view('admin.projects.edit', compact('project', 'clients'));
    }

    /**
     * Update the specified project in the database.
     *
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Remove the specified project from the database.
     *
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project)
    {
        $this->projectRepository->delete($project);

        return redirect()->route('projects.index');
    }

}
