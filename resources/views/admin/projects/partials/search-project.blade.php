<x-search class="pb-4"  method="get" id="search-project-form" action="{{ route('admin.projects.index') }}">
    @method('GET')

    <x-search-label for="search"/>

    <x-search-input
        name="search"
        id="search"
        :value="old('search')"
        placeholder="Nome, CPF/CNPJ, Email, Telefone..."
    />
    <x-input-error :messages="$errors->get('search')" class="mt-2 error-message" />

    <x-search-button>
        {{ __('Procurar') }}
    </x-search-button>
</x-search>
