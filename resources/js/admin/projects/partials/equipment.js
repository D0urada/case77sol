export let equipmentList = {};

export function setupEquipmentListener() {
    const equipmentSelect = document.getElementById('equipment');
    if (equipmentSelect) {
        equipmentSelect.addEventListener('change', (event) => {
            const selectedEquipment = event.target.value;
            addInputField(selectedEquipment);
        });
    } else {
        console.error('Select de equipamentos não encontrado!');
    }

    loadEquipmentFields();
}

export function loadEquipmentFields() {
    // Garantir que window.equipmentList esteja inicializado corretamente
    if (!window.equipmentList || Object.keys(window.equipmentList).length === 0) {
        console.error("Nenhum equipamento encontrado!");
        return;
    }

    // Adicionando os campos para os equipamentos já armazenados
    Object.keys(window.equipmentList).forEach(equipment => {
        const quantity = window.equipmentList[equipment];
        addInputField(equipment, quantity);
    });
}

export function addInputField(equipment = null, quantity = 1) {
    if (typeof window.equipmentList === 'undefined') {
        window.equipmentList = {};  // Inicializa, se necessário
    }

    const equipmentSelect = document.getElementById('equipment');
    const selectedEquipment = equipment || equipmentSelect.value; // Se não passar "equipment", usa o valor do select
    const quantityFields = document.getElementById('quantity-fields');

    console.log(equipmentSelect);
    console.log(selectedEquipment);
    console.log(quantityFields);

    if (!selectedEquipment) {
        console.error("Equipamento não selecionado");
        return;
    }

    // Verificando se o equipamento já foi adicionado
    if (window.equipmentList[selectedEquipment]) {
        //console.log(`Equipamento ${selectedEquipment} já foi adicionado`);
        return;
    }

    const inputDiv = document.createElement('div');
    inputDiv.classList.add(
        'bg-gray-50', 'border', 'border-gray-300', 'text-gray-900', 'text-sm', 'rounded-lg',
        'focus:ring-blue-500', 'focus:border-blue-500', 'block', 'w-full', 'p-2.5',
        'dark:bg-gray-700', 'dark:border-gray-600', 'dark:placeholder-gray-400', 'dark:text-white',
        'dark:focus:ring-blue-500', 'dark:focus:border-blue-500', 'shadow-sm', 'mb-2'
    );
    inputDiv.id = selectedEquipment;
    const equipmentLabel = document.createElement('span');
    equipmentLabel.classList.add('font-medium', 'text-sm', 'text-gray-700', 'dark:text-gray-300');
    equipmentLabel.textContent = `${selectedEquipment}: `;

    const quantityInput = document.createElement('input');
    quantityInput.type = 'number';
    quantityInput.name = `${selectedEquipment}_quantity`;
    quantityInput.min = '1';
    quantityInput.value = quantity;
    quantityInput.classList.add(
        'bg-gray-50', 'border', 'border-gray-300', 'text-gray-900', 'text-sm',
        'rounded-lg', 'focus:ring-blue-500', 'focus:border-blue-500', 'block',
        'w-full', 'p-2.5', 'dark:bg-gray-700', 'dark:border-gray-600',
        'dark:placeholder-gray-400', 'dark:text-white', 'dark:focus:ring-blue-500',
        'dark:focus:border-blue-500', 'w-20', 'px-3', 'py-2', 'focus:outline-none',
        'focus:ring-indigo-500', 'focus:border-indigo-500', 'sm:text-sm'
    );

    const removeButton = document.createElement('button');
    removeButton.classList.add('text-red-500', 'hover:text-red-700');
    removeButton.type = 'button';
    removeButton.textContent = 'Remover';
    removeButton.onclick = () => {
        inputDiv.remove();
        delete window.equipmentList[selectedEquipment]; // Remove o equipamento da lista

        // Recarrega os campos de equipamentos para garantir que o estado esteja atualizado
        loadEquipmentFields();
    };

    inputDiv.appendChild(equipmentLabel);
    inputDiv.appendChild(quantityInput);
    inputDiv.appendChild(removeButton);

    quantityFields.appendChild(inputDiv);

    window.equipmentList[selectedEquipment] = parseInt(quantityInput.value);
}
