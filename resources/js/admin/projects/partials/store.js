import axios from 'axios';
import { handleFormError, showErrorMessages, clearErrorMessages, showSuccessMessage } from '../../notifications.js';
import { setupMasksListener } from '../../masks.js';
import { setupEquipmentListener, equipmentList } from './equipment.js';

/**
 * Sets up event listeners for the project creation form.
 *
 * This function sets up event listeners on the project creation form to
 * handle user input and trigger the creation functionality.
 *
 * @return {void}
 */
export const setupStoreListener = () => {
    // Sets up event listeners for the form fields.
    setupMasksListener();

    // Captures the project creation form.
    const form = document.getElementById('create-project-form');

    if (form) {
        // Adds the event listener for the form.
        form.addEventListener('submit', handleFormSubmit);
    } else {
        console.error('Formulário de criação de projeto não encontrado!');
    }

    // Adds the event listener for the equipment.
    setupEquipmentListener();
};

/**
 * Handles the project creation form submission event.
 *
 * This function handles the submission event of the project creation form by
 * preventing the default form behavior and sending the form data to the server
 * via an AJAX request.
 *
 * @param {Event} event - The submission event.
 * @return {void}
 */
async function handleFormSubmit(event) {
    event.preventDefault();
    const form = event.target;

    const formAction = form.action;

    const formData = new FormData(form);

    // Prepare the equipment data to be sent to the server
    const equipmentData = Object.keys(window.equipmentList).map(equipment => ({
        name: equipment,
        quantity: window.equipmentList[equipment]
    }));

    formData.append('equipment', JSON.stringify(equipmentData));

    console.log(formData);

    // Send the form data to the server via an AJAX request
    await submitForm(formAction, formData);
}

/**
 * Submits the project creation form via AJAX.
 *
 * This function takes a form action and a FormData object as arguments and
 * sends the form data to the server via an AJAX request. If the request is
 * successful, it clears any error messages from the form and displays a
 * success message. If the request fails, it displays the errors using the
 * handleFormError function.
 *
 * @param {string} formAction - The action URL of the form.
 * @param {FormData} formData - The form data to be sent to the server.
 * @return {void}
 */
async function submitForm(formAction, formData) {
    try {
        // Send the form data to the server via an AJAX request
        const response = await axios.post(formAction, formData, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'multipart/form-data',
            },
        });

        // If the request is successful, clear any error messages from the form
        // and display a success message
        clearErrorMessages();
        showSuccessMessage(response.data.message);

        // After 2 seconds, redirect the user to the projects list page
        setTimeout(() => {
            window.location.href = '/admin/projects';
        }, 2000);
    } catch (error) {
        // If the request fails, display the errors using the handleFormError function
        handleFormError(error);
    }
}
