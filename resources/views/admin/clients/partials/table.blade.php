<x-table>
    <x-slot name="tableHead">
        <tr>
            <th scope="col" class="px-6 py-3">
                CPF/CNPJ
            </th>
            <th scope="col" class="px-6 py-3">
                Nome
            </th>
            <th scope="col" class="px-6 py-3">
                Email
            </th>
            <th scope="col" class="px-6 py-3">
                Telefone
            </th>
            <th scope="col" class="px-6 py-3 text-center">
                Ações
            </th>
        </tr>
    </x-slot>
    <x-slot name="tableBody">
        @forelse ($clients as $client)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ applyCpfCnpjMask($client->cpfcnpj) }}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $client->name }}
                </th>
                <td class="px-6 py-4">
                    {{ $client->email }}
                </td>
                <td class="px-6 py-4">
                    {{ $client->phone }}
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('admin.clients.show', $client->id) }}">
                        <x-outline-button
                            title="Ver detalhes do Cliente"
                            class="mb-5 edit-client-button"
                            data-client-id="{{ $client->id }}"
                        >
                            <x-slot name="dark">
                                <svg class="w-4 h-4 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4H1m3 4H1m3 4H1m3 4H1m6.071.286a3.429 3.429 0 1 1 6.858 0M4 1h12a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Zm9 6.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"></path>
                                </svg>
                            </x-slot>
                        </x-outline-button>
                    </a>
                </td>
            </tr>
        @empty
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td colspan="100" class="px-6 py-4 text-center">
                    Nenhum dado cadastrado
                </td>
            </tr>
        @endforelse
    </x-slot>
</x-table>
