<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Collection;

interface EquipmentRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): Equipment;
}
