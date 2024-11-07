<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Editar Cliente') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Atualize os dados do cliente.") }}
        </p>
    </header>

    <x-alert-success/>

    <form method="post" id="update-client-form" action="{{ route('admin.clients.update', $client->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="name" :value="__('Nome')" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="block w-full mt-1"
                :value="old('name', $client->name)"
                required
                autofocus
                autocomplete="Nome" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" class="mt-2 error-message" />
        </div>

        <div class="mt-4">
			<x-input-label for="email" :value="__('Email')" />
			<x-text-input
				id="email"
				class="block w-full mt-1"
				type="email"
				name="email"
				:value="old('email', $client->email)"
                required
                autofocus
                autocomplete="Email" />
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
				:value="old('cpfcnpj', applyCpfCnpjMask($client->cpfcnpj))"
                required
                autofocus
                autocomplete="CPF/CNPJ" />
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
				:value="old('phone', $client->phone)"
                required
                autofocus
                autocomplete="Telefone" />
			<x-input-error :messages="$errors->get('phone')" class="mt-2 error-message" />
		</div>

        <div class="flex items-center gap-4">
            <a href="{{ route('admin.clients.index') }}">
                <x-secondary-button>
                    {{ __('Cancelar') }}
                </x-secondary-button>
            </a>

			<x-primary-button class="ms-4">
				{{ __('Salvar') }}
			</x-primary-button>
        </div>
    </form>
</section>
