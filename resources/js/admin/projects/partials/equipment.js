export let equipmentList = {};

/**
 * Sets up the event listener for the equipment selection dropdown.
 *
 * This function initializes the equipment selection dropdown with an event listener
 * that triggers the addition of a new input field for the selected equipment. It also
 * loads existing equipment fields on initialization.
 */
export function setupEquipmentListener() {
    const equipmentSelect = document.getElementById('equipment');

    if (equipmentSelect) {
        // Adds an event listener for changes in the equipment dropdown
        equipmentSelect.addEventListener('change', (event) => {
            const selectedEquipment = event.target.value;
            // Adds an input field for the newly selected equipment
            addInputField(selectedEquipment);
        });
    } else {
        console.error('Select de equipamentos não encontrado!'); // Logs error if dropdown is not found
    }

    // Loads existing equipment fields on initialization
    loadEquipmentFields();
}

/**
 * Carrega os campos de equipamentos.
 *
 * Verifica se a lista de equipamentos "equipmentList" existe e tem algum item.
 * Se sim, adiciona um input field para cada equipamento com a quantidade
 * correspondente.
 */
export function loadEquipmentFields() {
    if (!window.equipmentList || Object.keys(window.equipmentList).length === 0) {
        console.error("Nenhum equipamento encontrado!");
        return;
    }

    // Adiciona um input field para cada equipamento com a quantidade correspondente
    Object.keys(window.equipmentList).forEach(equipment => {
        const quantity = window.equipmentList[equipment];
        addInputField(equipment, quantity);
    });
}

/**
 * Adds an input field for the specified equipment.
 * If no equipment is specified, it uses the selected equipment from the dropdown.
 *
 * @param {string|null} equipment - The equipment to add. Defaults to null.
 * @param {number} quantity - The initial quantity for the equipment. Defaults to 1.
 */
export function addInputField(equipment = null, quantity = 1) {
    // Initialize equipmentList if it's not defined
    if (typeof window.equipmentList === 'undefined') {
        window.equipmentList = {};
    }

    // Get the equipment dropdown and the selected equipment
    const equipmentSelect = document.getElementById('equipment');
    const selectedEquipment = equipment || equipmentSelect.value;
    // Get the container for quantity input fields
    const quantityFields = document.getElementById('quantity-fields');

    if (!selectedEquipment) {
        console.error("Equipamento não selecionado");
        return;
    }

    // Check if the equipment is already added
    if (window.equipmentList[selectedEquipment]) {
        return;
    }

    // Create a new div to hold the input field and buttons
    const inputDiv = document.createElement('div');
    inputDiv.classList.add(
        'bg-gray-50', 'border', 'border-gray-300', 'text-gray-900', 'text-sm', 'rounded-lg',
        'focus:ring-blue-500', 'focus:border-blue-500', 'block', 'w-full', 'p-2.5',
        'dark:bg-gray-700', 'dark:border-gray-600', 'dark:placeholder-gray-400', 'dark:text-white',
        'dark:focus:ring-blue-500', 'dark:focus:border-blue-500', 'shadow-sm', 'mb-2'
    );
    inputDiv.id = selectedEquipment;

    // Create a label for the equipment
    const equipmentLabel = document.createElement('span');
    equipmentLabel.classList.add('font-medium', 'text-sm', 'text-gray-700', 'dark:text-gray-300');
    equipmentLabel.textContent = `${selectedEquipment}: `;

    // Create an input field for the quantity
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

    // Create a button to remove the input field
    const removeButton = document.createElement('button');
    removeButton.classList.add('text-red-500', 'hover:text-red-700');
    removeButton.type = 'button';
    removeButton.textContent = 'Remover';
    removeButton.onclick = () => {
        inputDiv.remove();
        delete window.equipmentList[selectedEquipment];
        loadEquipmentFields();
    };

    // Append the label, input field, and remove button to the div
    inputDiv.appendChild(equipmentLabel);
    inputDiv.appendChild(quantityInput);
    inputDiv.appendChild(removeButton);

    // Append the div to the container of quantity fields
    quantityFields.appendChild(inputDiv);

    // Update the equipment list with the new equipment and its quantity
    window.equipmentList[selectedEquipment] = parseInt(quantityInput.value);
}
