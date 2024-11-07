<x-modal-crud name="create-client" :show="false" focusable>
	<x-alert-success/>

	<form method="post" id="create-client-form" action="{{ route('admin.clients.store') }}" class="p-6">
		@csrf
		@method('POST')

		<x-slot name="modalHeader">
			{{ __('Cadastro de Clientes') }}
		</x-slot>

		<div>
			<x-input-label for="name" :value="__('Nome')" />
			<x-text-input
				id="name"
				class="block w-full mt-1"
				type="text"
                name="name"
				:value="old('name')"
				placeholder="{{ __('José da Silva') }}"
				required
				autofocus
			/>
			<x-input-error :messages="$errors->get('name')" class="mt-2 error-message" />
		</div>

		<div class="mt-4">
			<x-input-label for="email" :value="__('Email')" />
			<x-text-input
				id="email"
				class="block w-full mt-1"
				type="email"
				name="email"
				:value="old('email')"
				placeholder="{{ __('teste@me.com') }}"
				required
			/>
			<x-input-error :messages="$errors->get('email')" class="mt-2 error-message" />
		</div>

		<div class="mt-4">
			<x-input-label for="cpfcnpj" :value="__('CPF/CNPJ')" />
			<x-text-input
				id="cpfcnpj"
				class="block w-full mt-1"
				type="text"
				inputmode="numeric"
				maxlength="18"
				pattern="^(\d{3}\.\d{3}\.\d{3}-\d{2}|\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2})$"
				name="cpfcnpj"
				:value="old('cpfcnpj')"
				placeholder="{{ __('123.456.789-00 ou 00.623.904/0001-73') }}"
				required
			/>
			<x-input-error :messages="$errors->get('cpfcnpj')" class="mt-2 error-message" />
		</div>

		<div class="mt-4">
			<x-input-label for="phone" :value="__('Telefone')" />
			<x-text-input
				id="phone"
				class="block w-full mt-1"
				type="tel"
				pattern="^\(\d{2}\) \d{5}-\d{4}$"
				name="phone"
				:value="old('phone')"
				placeholder="{{ __('(00) 0000-0000') }}"
				required
			/>
			<x-input-error :messages="$errors->get('phone')" class="mt-2 error-message" />
		</div>

		<div class="flex justify-end mt-6">
			<x-secondary-button x-on:click="$dispatch('close')">
				{{ __('Cancelar') }}
			</x-secondary-button>

			<x-primary-button class="ms-4">
				{{ __('Cadastrar') }}
			</x-primary-button>
		</div>
	</form>
</x-modal-crud>
