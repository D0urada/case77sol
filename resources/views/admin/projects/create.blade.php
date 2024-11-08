<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Projeto') }}
        </h2>
    </x-slot>

    <x-section class="!py-12">
        <x-alert/>

        <div class="max-full">
            @include('admin.projects.partials.create-project-form')
        </div>
    </x-section>

</x-admin-layout>


<!-- Include the JavaScript file -->
@vite(['resources/js/admin/projects/create.js'])
