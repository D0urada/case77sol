<?php

namespace App\Repositories;

use App\Models\Uf;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\UfRepositoryInterface;

class UfRepository implements UfRepositoryInterface
{
    public function all(): Collection
    {
        return Uf::all();
    }

    public function find(int $id): Uf
    {
        return Uf::findOrFail($id);
    }
}
