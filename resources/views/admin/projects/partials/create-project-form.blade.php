<section class="w-full max-w-2xl px-6 lg:max-w-7xl ">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Cadastrar Projeto') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Cadastre um novo Projeto.") }}
        </p>
    </header>

    <x-alert-success/>

    <form method="post" id="create-project-form" action="{{ route('admin.projects.store') }}">
        @csrf
        @method('POST')

        <div class="grid grid-cols-2 gap-4 mt-6 mb-6">
            <div>
                <x-input-label for="name" :value="__('Nome do Projeto')" />
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="block w-full mt-1"
                    :value="old('name')"
                    required
                />
                <x-input-error class="mt-2" :messages="$errors->get('name')" class="mt-2 error-message" />
            </div>

            <div>
                <x-input-label for="client_search" :value="__('Buscar Cliente, recomendado CPF/CNPJ')" />
                <x-text-input
                    id="client_search"
                    type="text"
                    class="block w-full mt-1"
                    placeholder="Digite o nome, cpf/cnpj ou email do cliente"
                    required
                />
                <x-select
                    name="client_id"
                    id="client_id"
                    class="block w-full mt-1"
                    required
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
                        required
                    >
                            <option value="">{{ __('Selecione um Tipo') }}</option>
                        @forelse ($installationTypeList as $type)
                            <option value="{{ $type->name }}">{{ $type->name }}</option>
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
                            <option value="{{ $uf->acronym }}">{{ $uf->acronym }} - {{ $uf->name }}</option>
                        @empty
                            <option value="">{{ __('Nenhuma UF') }}</option>
                        @endforelse
                    </x-select>
                <x-input-error class="mt-2" :messages="$errors->get('installation_type')" />
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

            <!-- Container para os campos de quantidade -->
            <div id="quantity-fields" class="mt-4 space-y-2"></div>
        </div>

        <div class="w-full">
            <x-input-label for="description" :value="__('Descrição')" />
            <x-textarea
                id="description"
                name="description"
                rows="4"
                type="text"
                :value="old('description')"
                placeholder="Descrição do Projeto"
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
