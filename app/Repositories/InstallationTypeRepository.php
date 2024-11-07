<?php

namespace App\Repositories;

use App\Models\InstallationType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\InstallationTypeRepositoryInterface;

class InstallationTypeRepository implements InstallationTypeRepositoryInterface
{
    public function all(): Collection
    {
        return InstallationType::all();
    }

    public function find(int $id): InstallationType
    {
        return InstallationType::findOrFail($id);
    }
}
