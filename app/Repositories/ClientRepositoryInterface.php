<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ClientRepositoryInterface
{
	public function paginate(): LengthAwarePaginator;

    public function create(array $data): Client;

    public function update(array $data, Client $client): Client;

    public function findById(int $id): ?Client;

    public function delete(Client $client): void;
}
