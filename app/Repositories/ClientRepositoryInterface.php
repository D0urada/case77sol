<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ClientRepositoryInterface
{
	public function paginate(): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function create(array $data): Client;

    public function update(Client $client, array $data): Client;

    public function delete(Client $client): void;
}