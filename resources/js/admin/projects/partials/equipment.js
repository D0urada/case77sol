
export let equipmentList = {};

export function setupEquipmentListener() {
    const equipmentSelect = document.getElementById('equipment');
    if (equipmentSelect) {
        equipmentSelect.addEventListener('change', addInputField);
    } else {
        console.error('Select de equipamentos não encontrado!');
    }
}

export function addInputField() {
    const equipmentSelect = document.getElementById('equipment');
    const selectedEquipment = equipmentSelect.value;
    const quantityFields = document.getElementById('quantity-fields');

    if (selectedEquipment && !equipmentList[selectedEquipment]) {
        const inputDiv = document.createElement('div');
        inputDiv.classList.add('flex', 'items-center', 'space-x-2', 'border', 'p-2', 'rounded-lg', 'shadow-sm', 'mb-2');

        const equipmentLabel = document.createElement('span');
        equipmentLabel.classList.add('text-sm', 'font-medium', 'text-gray-700');
        equipmentLabel.textContent = selectedEquipment;

        const quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.name = `${selectedEquipment}_quantity`;
        quantityInput.min = '1';
        quantityInput.value = '1';
        quantityInput.classList.add('w-20', 'px-3', 'py-2', 'border', 'border-gray-300', 'rounded-md', 'focus:outline-none', 'focus:ring-indigo-500', 'focus:border-indigo-500', 'sm:text-sm');

        const removeButton = document.createElement('button');
        removeButton.classList.add('text-red-500', 'hover:text-red-700');
        removeButton.textContent = 'Remover';
        removeButton.onclick = () => {
            inputDiv.remove();
            delete equipmentList[selectedEquipment];
        };

        inputDiv.appendChild(equipmentLabel);
        inputDiv.appendChild(quantityInput);
        inputDiv.appendChild(removeButton);

        quantityFields.appendChild(inputDiv);

        equipmentList[selectedEquipment] = parseInt(quantityInput.value);
    }

    equipmentSelect.value = '';
}
