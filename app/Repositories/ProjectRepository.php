<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * Retrieve paginated projects from the repository.
     *
     * This method retrieves projects from the repository with pagination.
     * The paginated data includes projects and pagination information,
     * which can be directly passed to the view.
     *
     * @param int $perPage The number of items to display per page. Defaults to 15.
     *
     * @return LengthAwarePaginator The paginated list of projects.
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Project::with('client')->paginate($perPage);
    }

    /**
     * Retrieve paginated projects from the repository by searching for the given query.
     *
     * This method retrieves projects from the repository by searching for the given query
     * and returns the results as a paginated list of project instances.
     *
     * @param string $searchQuery The search query to filter the results by.
     * @param int $perPage The number of items to display per page. Defaults to 15.
     *
     * @return LengthAwarePaginator The paginated list of projects.
     */
    public function search(string $searchQuery, int $perPage = 15): LengthAwarePaginator
    {
        // Search projects by name, description, location UF, installation type, or client name
        $query = Project::with('client')
            ->where(function($query) use ($searchQuery) {
                // Search by name, description, location UF, or installation type
                $query->where('name', 'like', '%'.$searchQuery.'%')
                    ->orWhere('description', 'like', '%'.$searchQuery.'%')
                    ->orWhere('location_uf', 'like', '%'.$searchQuery.'%')
                    ->orWhere('installation_type', 'like', '%'.$searchQuery.'%');
            })
            ->orWhereHas('client', function($query) use ($searchQuery) {
                // Search by client name
                $query->where('name', 'like', '%'.$searchQuery.'%');
            });

        // Return the paginated results
        return $query->paginate($perPage);
    }


    /**
     * Retrieve all projects from the repository.
     *
     * This method retrieves all projects from the repository and returns them
     * as a collection of project instances.
     *
     * @return Collection The collection of all projects.
     */
    public function all(): Collection
    {
        return Project::all();
    }

    /**
     * Retrieve a client by ID from the repository.
     *
     * This method fetches a client by its ID. If no client is found,
     * it returns null.
     *
     * @param int $id The ID of the client to retrieve.
     *
     * @return Client|null The client instance or null if not found.
     */
    public function findById(int $id): ?Project
    {
        return Project::with('client')->find($id);
    }

    /**
     * Create a new project in the repository.
     *
     * This method creates a new project in the repository from the given data.
     *
     * @param array $data The array of data to create the project from.
     *
     * @return Project The newly created project.
     */
    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(array $data, Project $project): ?Project
    {
        // Update the project with the given data and return the result
        return $project->update($data);
    }

    public function delete(Project $project): void
    {
        // Delete the project from the repository
        $project->delete();
    }
}
