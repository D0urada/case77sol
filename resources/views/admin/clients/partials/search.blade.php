<x-search class="mb-5" id="search-form">

    <x-search-label for="clients-search"/>

    <x-search-input
        name="clients-search"
        id="clients-search"
        placeholder="Nome, CPF/CNPJ, Email, Telefone..."
    />
    <x-input-error :messages="$errors->get('clients-search')" class="mt-2 error-message" />

    <x-search-button>
        {{ __('Procurar') }}
    </x-search-button>
</x-search>
