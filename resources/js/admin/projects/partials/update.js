import axios from 'axios';
import { handleFormError, showErrorMessages, clearErrorMessages, showSuccessMessage } from '../../notifications.js';
import { setupMasksListener } from '../../masks.js';
import { setupEquipmentListener, equipmentList } from './equipment.js';

/**
 * Sets up the event listeners for the project update form.
 *
 * This function sets up event listeners for the project update form to
 * handle user input and trigger the update functionality.
 */
export const setupUpdateListener = () => {
    // Sets up event listeners for the form fields.
    setupMasksListener();

    // Captures the project update form.
    const form = document.getElementById('update-project-form');

    if (form) {
        // Adds the event listener for the form.
        form.addEventListener('submit', handleFormSubmit);
    } else {
        console.error('Formulário de atualização de projeto não encontrado!');
    }

    // Sets up the event listener for the equipment.
    setupEquipmentListener();
};

/**
 * Handles the project update form submission event.
 * @param {Event} event - The form submission event.
 */
async function handleFormSubmit(event) {
    event.preventDefault();
    const form = event.target;

    const formAction = form.action;

    // Creates a FormData object with the form data.
    const formData = new FormData(form);

    // If the form has an equipment field, it parses the JSON data of the selected equipment.
    const equipmentField = form.querySelector('[name="equipment"]');
    const existingEquipment = equipmentField && equipmentField.value ?
    (() => {
      try {
        return JSON.parse(equipmentField.value);
      } catch (error) {
        console.error('Erro ao analisar o JSON do equipamento:', error);
        return [];
      }
    })()
    : [];

    // Adds the equipment data to the form data.
    const equipmentData = Object.keys(window.equipmentList).map(equipment => ({
        name: equipment,
        quantity: window.equipmentList[equipment]
    }));

    console.log('Dados de equipamentos a enviar:', equipmentData);

    formData.append('equipment', JSON.stringify(equipmentData));

    console.log(formData);

    // Submits the form via AJAX.
    await submitForm(formAction, formData);
}

/**
 * Submits the form via AJAX.
 * @param {string} formAction - The URL to submit the form to.
 * @param {FormData} formData - The form data to send.
 */
async function submitForm(formAction, formData) {
    try {
        // Sends a POST request with the form data to the specified URL.
        const response = await axios.post(formAction, formData, {
            headers: {
                // Indicates that the request is an AJAX request.
                'X-Requested-With': 'XMLHttpRequest',
                // Specifies the content type of the request body.
                'Content-Type': 'multipart/form-data',
            },
        });

        // Clears any previous error messages.
        clearErrorMessages();

        // Displays the success message received in the response.
        showSuccessMessage(response.data.message);

        // Reloads the page after 2 seconds.
        setTimeout(() => location.reload(), 2000);
    } catch (error) {
        // Handles any errors that occur during form submission.
        handleFormError(error);
    }
}
