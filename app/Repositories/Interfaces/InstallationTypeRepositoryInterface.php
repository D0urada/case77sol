<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\InstallationType;
use Illuminate\Database\Eloquent\Collection;

interface InstallationTypeRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): InstallationType;
}
