<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ClientRepositoryInterface
{
	public function paginate(): LengthAwarePaginator;

    public function search(string $searchQuery, int $paginate = 15): LengthAwarePaginator;

    public function create(array $data): Client;

    public function update(array $data, Client $client): Client;

    public function findById(int $id): ?Client;

    public function delete(Client $client): void;
}
