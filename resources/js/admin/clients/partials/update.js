import axios from 'axios';
import { handleFormError, showErrorMessages, clearErrorMessages, showSuccessMessage } from '../../notifications.js';
import { setupMasksListener } from '../../masks.js';

/**
 * Sets up the client update form.
 */
export const setupUpdateListener = () => {
    // Sets up event listeners for the form fields.
    setupMasksListener();

    const form = document.getElementById('update-client-form');

    if (form) {
        // Adds the event listener for the form.
        form.addEventListener('submit', handleFormSubmit);
    } else {
        console.error('Formulário de atualização de cliente não encontrado!');
    }
};

/**
 * Handles the client update form submission event.
 * @param {Event} event - The form submission event.
 */
async function handleFormSubmit(event) {
    // Prevents the default form behavior and prevents the form from being submitted by navigation.
    event.preventDefault();

    // Captures the submitted form.
    const form = event.target;

    // Calls the function to submit the form via AJAX.
    await submitForm(form);
}

/**
 * Submits the client update form via AJAX.
 * @param {HTMLFormElement} form - The form that will be submitted.
 */
async function submitForm(form) {
    // Gets the action URL of the form.
    const url = form.action;

    // Creates a FormData object with the form data.
    const formData = new FormData(form);

    // Sends a POST request to the form URL with the data.
    try {
        const response = await axios.post(url, formData, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        // Clears previous error messages.
        clearErrorMessages();

        // Displays the success message received in the response.
        showSuccessMessage(response.data.message);

        // Waits 2 seconds and reloads the page.
        setTimeout(() => location.reload(), 2000);
    } catch (error) {
        // Handles form submission errors.
        handleFormError(error);
    }
}
