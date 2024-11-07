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

    public function findById(int $id): ?Project;

    public function create(array $data): Project;

    public function update(array $data, Project $project): ?Project;

    public function delete(Project $project): void;
}

