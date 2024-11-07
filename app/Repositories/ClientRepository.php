<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Interfaces\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    /**
	 * Retrieve paginated clients from the repository.
	 *
	 * This method retrieves all clients from the repository with pagination.
	 * The paginated data includes clients and pagination information,
	 * which can be directly passed to the view.
	 *
	 * @return LengthAwarePaginator The paginated list of clients.
	 */
	public function paginate(int $int = 15): LengthAwarePaginator
	{
		return Client::paginate($int);
	}

    public function search(string $searchQuery): Builder
    {
        $query = Client::query();

        if ($searchQuery) {
            $cpfCnpjQuery = removeCpfCnpjMask($searchQuery);

            $query->where(function ($q) use ($searchQuery, $cpfCnpjQuery) {
                $q
                  ->orWhere('name', 'like', '%' . $searchQuery . '%')
                  ->orWhere('email', 'like', '%' . $searchQuery . '%')
                  ->orWhere('cpfcnpj', 'like', '%' . $cpfCnpjQuery . '%')
                  ->orWhere('phone', 'like', '%' . $searchQuery . '%');
            });
        }

        return $query;
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
    public function update(array $data, Client $client): Client
    {
        $client->update($data);
        return $client;
    }

    /**
     * Retrieve a client by ID from the repository.
     *
     * This method fetches a client by its ID. If no client is found,
     * it returns null.
     *
     * @param int $id The ID of the client to retrieve.
     *
     * @return Client|null The client instance or null if not found.
     */
    public function findById(int $id): ?Client
    {
        return Client::find($id);
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
