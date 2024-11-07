<section class="w-full max-w-2xl px-6 lg:max-w-7xl ">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Editar Projeto') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Atualize os dados do Projeto.") }}
        </p>
    </header>

    <x-alert-success/>

    <form method="PUT" id="update-project-form" action="{{ route('admin.projects.update', $project->id) }}" >
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4 mt-6 mb-6">
            <div>
                <x-input-label for="name" :value="__('Nome do Projeto')" />
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="block w-full mt-1"
                    :value="old('name', $project->name)"
                    required
                    autofocus
                />
                <x-input-error class="mt-2" :messages="$errors->get('name')" class="mt-2 error-message" />
            </div>

            <div>
                <x-input-label for="client_search" :value="__('Buscar Cliente, recomendado CPF/CNPJ')" />
                <x-text-input
                    id="client_search"
                    name="client_search"
                    type="text"
                    class="block w-full mt-1"
                    placeholder="Digite o nome, cpf/cnpj ou email do cliente"
                    :value="old('client_search', applyCpfCnpjMask($project->client->cpfcnpj))"
                    required
                    autofocus
                />
                <x-select
                    name="client_id"
                    id="client_id"
                    class="block w-full mt-1"
                >
                    <option value="">{{ __('Selecione um cliente') }}</option>
                </x-select>
                <x-input-error class="mt-2" :messages="$errors->get('client_id')" />
            </div>

            <div>
                <x-input-label for="installation_type" :value="__('Tipo de Instalação')" />
                <x-select
                    name="installation_type"
                    id="installation_type"
                    class="block w-full mt-1"
                    :value="old('installation_type', $project->installation_type)"
                    required
                    autofocus
                >
                    <option value="">{{ __('Selecione um Tipo') }}</option>
                    @forelse ($installationTypeList as $type)
                        <option value="{{ $type->name }}"
                            {{ old('installation_type', $project->installation_type) == $type->name ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @empty
                        <option value="">{{ __('Nenhum Tipo de Instalação') }}</option>
                    @endforelse
                </x-select>
                <x-input-error class="mt-2" :messages="$errors->get('installation_type')" />
            </div>

            <div>
                <x-input-label for="location_uf" :value="__('Local do Projeto:')" />
                <x-select
                    name="location_uf"
                    id="location_uf"
                    class="block w-full mt-1"
                    required
                >
                    <option value="">{{ __('Selecione uma UF') }}</option>
                    @forelse ($ufList as $uf)
                        <option value="{{ $uf->acronym }}"
                            {{ old('location_uf', $project->location_uf) == $uf->acronym ? 'selected' : '' }}>
                            {{ $uf->acronym }} - {{ $uf->name }}
                        </option>
                    @empty
                        <option value="">{{ __('Nenhuma UF') }}</option>
                    @endforelse
                </x-select>
                <x-input-error class="mt-2" :messages="$errors->get('location_uf')" />
            </div>
        </div>

        <div>
            <x-input-label for="equipment" :value="__('Adicione um Equipamento:')" />
                <x-select
                    name="equipment"
                    id="equipment"
                    class="block w-full mt-1"
                >
                        <option value="" selected> Selecione um equipamento</option>
                        @forelse ($equipmentList as $equipment)
                            <option value="{{ $equipment->name }}">{{ $equipment->name }}</option>
                        @empty
                            <option value="" selected> Nenhum Equipamento</option>
                        @endforelse
                </x-select>
            <x-input-error class="mt-2" :messages="$errors->get('installation_type')" />

            <div id="quantity-fields" class="mt-4 space-y-2">
                @foreach (json_decode($initialEquipmentList) as $initialEquipment)
                    <div id={{ $initialEquipment->name }} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 shadow-sm mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ $initialEquipment->name }}
                        </span>
                        <input type="number" value="{{ $initialEquipment->quantity }}" name="{{ $initialEquipment->name }}_quantity" min="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-20 px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <button class="text-red-500 hover:text-red-700" type="button">Remover</button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="w-full">
            <x-input-label for="description" :value="__('Descrição')" />
            <x-textarea
                id="description"
                name="description"
                rows="4"
                type="text"
                :value="old('name', $project->description)"
                autofocus
            />
            <x-input-error class="mt-2" :messages="$errors->get('description')" class="mt-2 error-message" />
        </div>

        <div class="flex items-center gap-4 mt-6">
            <a href="{{ route('admin.projects.index') }}">
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
