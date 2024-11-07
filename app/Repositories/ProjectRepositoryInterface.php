<?php

namespace App\Repositories;

use App\Models\Project;

interface ProjectRepositoryInterface
{
    public function paginate(int $perPage = 15);

    public function search(string $searchQuery, int $perPage = 15);

    public function create(array $data);

    public function update(Project $project, array $data);

    public function delete(Project $project);
}

