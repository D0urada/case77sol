<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function paginate(int $perPage = 15)
    {
        return Project::paginate($perPage);
    }

    public function search(string $searchQuery, int $perPage = 15)
    {
        return Project::where('name', 'like', '%'.$searchQuery.'%')
            ->orWhere('description', 'like', '%'.$searchQuery.'%')
            ->paginate($perPage);
    }

    public function create(array $data)
    {
        return Project::create($data);
    }

    public function update(Project $project, array $data)
    {
        return $project->update($data);
    }

    public function delete(Project $project)
    {
        return $project->delete();
    }
}
