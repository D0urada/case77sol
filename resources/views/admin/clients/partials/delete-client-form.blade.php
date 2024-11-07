<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Excluir Cliente') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Caso exclua o Cliente, os Projetos asociados a ele tambem serão excluidos.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-client-deletion')"
    >{{ __('Excluir Cliente') }}</x-danger-button>

    <x-modal name="confirm-client-deletion" focusable>
        <form method="post" id="delete-client-form" action="{{ route('admin.clients.destroy', $client->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Tem certeza que quer excluir o Cliente?') }}
                <br/>
            </h2>

            <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                <li>
                    {{ $client->name }}
                </li>
                <li>
                    {{ $client->cpfcnpj }}
                </li>
                <li>
                    {{ $client->phone }}
                </li>
            </ul>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Caso exclua o Cliente, os Projetos asociados a ele tambem serão excluidos.') }}
            </p>

            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Excluir Cliente') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
