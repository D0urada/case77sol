<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Projeto') }}
        </h2>
    </x-slot>

    <x-section class="!py-0 !pt-12">
        <div class="max-w-xl">
            @include('admin.clients.partials.update-project-form')
        </div>
    </x-section>
    <x-section class="!py-0 !pt-4 !pb-12">
        <div class="max-w-xl">
            @include('admin.clients.partials.delete-project-form')
        </div>
    </x-section>
</x-admin-layout>


<!-- Include the JavaScript file -->
@vite(['resources/js/admin/projects/show.js'])
