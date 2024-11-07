<?php

namespace App\Repositories\Interfaces;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function search(string $searchQuery, int $perPage = 15): LengthAwarePaginator;

    public function all(): Collection;

    public function create(array $data): Project;

    public function update(Project $project, array $data);

    public function delete(Project $project): void;
}

