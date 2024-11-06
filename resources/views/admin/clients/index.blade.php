<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <x-section >
        <x-alert/>

        <x-secondary-button
            class="mb-5"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'create-client')"
        >
            {{ __('Cadastrar Cliente') }}
        </x-secondary-button>

        @include('admin.clients.partials.search')

        @include('admin.clients.partials.table', ['clients' => $clients])

        {{ $clients->links() }}
    </x-section>

    @include('admin.clients.partials.create-modal')

</x-admin-layout>

<!-- Include the JavaScript file -->
@vite(['resources/js/admin/clients/index.js'])
