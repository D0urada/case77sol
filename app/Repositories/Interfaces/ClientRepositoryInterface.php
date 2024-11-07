<?php

namespace App\Repositories\Interfaces;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

interface ClientRepositoryInterface
{
    /**
     * Retrieve paginated clients from the repository.
     *
     * @return LengthAwarePaginator
     */
    public function paginate(): LengthAwarePaginator;

    /**
     * Retrieve a query builder for clients that match the search query.
     *
     * @param string $searchQuery
     * @return Builder
     */
    public function search(string $searchQuery): Builder;

    /**
     * Create a new client in the repository.
     *
     * @param array $data
     * @return Client
     */
    public function create(array $data): Client;

    /**
     * Update an existing client in the repository.
     *
     * @param array $data
     * @param Client $client
     * @return Client
     */
    public function update(array $data, Client $client): Client;

    /**
     * Retrieve a client by ID from the repository.
     *
     * @param int $id
     * @return Client|null
     */
    public function findById(int $id): ?Client;

    /**
     * Delete a client from the repository.
     *
     * @param Client $client
     * @return void
     */
    public function delete(Client $client): void;
}
