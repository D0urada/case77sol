<x-admin-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
		    {{ __('Clientes') }}
		</h2>
	</x-slot>

	<x-section>
		<x-secondary-button
			class="mb-5"
			x-data=""
			x-on:click.prevent="$dispatch('open-modal', 'create-client')"
		>
			{{ __('Cadastrar Cliente') }}
		</x-secondary-button>

		@include('admin.clients.search')

		@include('admin.clients.table')

		{{ $clients->links() }}
	</x-section>

	@include('admin.clients.create-modal')

</x-admin-layout>


<!-- Include the JavaScript file -->
@vite(['resources/js/admin/clients/index.js'])
