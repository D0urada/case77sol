<x-search  method="get" id="search-client-form" action="{{ route('admin.clients.index') }}">
    @method('GET')

    <x-search-label for="search"/>

    <x-search-input
        name="search"
        id="search"
        placeholder="Nome, CPF/CNPJ, Email, Telefone..."
    />
    <x-input-error :messages="$errors->get('clients-search')" class="mt-2 error-message" />

    <x-search-button>
        {{ __('Procurar') }}
    </x-search-button>
</x-search>
