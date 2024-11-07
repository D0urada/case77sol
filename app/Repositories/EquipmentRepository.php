<?php

namespace App\Repositories;

use App\Models\Equipment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\EquipmentRepositoryInterface;

class EquipmentRepository implements EquipmentRepositoryInterface
{
    public function all(): Collection
    {
        return Equipment::all();
    }

    public function find(int $id): Equipment
    {
        return Equipment::findOrFail($id);
    }
}
