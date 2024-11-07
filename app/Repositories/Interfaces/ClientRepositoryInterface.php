<?php

namespace App\Repositories\Interfaces;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

interface ClientRepositoryInterface
{
    public function paginate(): LengthAwarePaginator;

    public function search(string $searchQuery): Builder;

    public function create(array $data): Client;

    public function update(array $data, Client $client): Client;

    public function findById(int $id): ?Client;

    public function delete(Client $client): void;
}
