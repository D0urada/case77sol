<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Deletar Projeto') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Deseja realmente excluir esse Projeto?.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-project-deletion')"
    >{{ __('Excluir Projeto') }}</x-danger-button>

    <x-modal name="confirm-project-deletion" focusable>
        <form method="post" id="delete-project-form" action="{{ route('admin.projects.destroy', $project->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Tem certeza que quer excluir o Projeto?') }}
                <br/>
            </h2>

            <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                <li>
                    {{ $project->name }}
                </li>
                <li>
                    {{ $project->client->name }}
                </li>
                <li>
                    {{ $project->client->cpfcnpj }}
                </li>
            </ul>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Caso exclua o Projeto, o cliente permanecerá.') }}
            </p>

            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Excluir Projeto') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
