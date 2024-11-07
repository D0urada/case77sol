<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Projetos') }}
        </h2>
    </x-slot>

    <x-section >
        <x-alert/>

        <a href="{{ route('admin.projects.create') }}">
            <x-secondary-button
                class="mb-5 edit-project-button">
                {{ __('Cadastrar Projeto') }}
            </x-secondary-button>
        </a>

        @include('admin.projects.partials.search-project')

        @include('admin.projects.partials.table-project', ['projects' => $projects])

        {{ $projects->links() }}
    </x-section>

</x-admin-layout>

<!-- Include the JavaScript file -->
@vite(['resources/js/admin/projects/index.js'])
