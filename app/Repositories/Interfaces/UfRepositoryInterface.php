<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Uf;
use Illuminate\Database\Eloquent\Collection;

interface UfRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): Uf;
}
