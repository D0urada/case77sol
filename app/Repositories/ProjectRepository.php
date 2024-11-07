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

    public function search(string $searchQuery, int $perPage = 15): LengthAwarePaginator
    {
        return Project::with('client')
            ->where('name', 'like', '%'.$searchQuery.'%')
            ->orWhere('description', 'like', '%'.$searchQuery.'%')
            ->paginate($perPage);
    }

    public function all(): Collection
    {
        return Project::all();
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

    public function update(Project $project, array $data)
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
