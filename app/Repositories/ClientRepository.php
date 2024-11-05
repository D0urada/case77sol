<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClientRepository implements ClientRepositoryInterface
{
	/**
	 * Retrieve paginated clients from the repository.
	 *
	 * This method retrieves all clients from the repository with pagination.
	 * The paginated data includes clients and pagination information,
	 * which can be directly passed to the view.
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated list of clients.
	 */
	public function paginate(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
	{
		return Client::paginate(15);
	}

    /**
     * Create a new client in the repository.
     *
     * @param array $data The array of data to create the client from.
     *
     * @return Client The newly created client.
     */
    public function create(array $data): Client
    {
        return Client::create($data);
    }

    /**
     * Update an existing client in the repository.
     *
     * @param Client $client The client instance to be updated.
     * @param array $data The array of data to update the client from.
     *
     * @return Client The updated client.
     */
    public function update(Client $client, array $data): Client
    {
        $client->update($data);
        return $client;
    }

    /**
     * Delete a client from the repository.
     *
     * This method deletes the given client instance from the repository.
     * It does not return any value.
     *
     * @param Client $client The client instance to be deleted.
     */
    public function delete(Client $client): void
    {
        $client->delete();
    }
}