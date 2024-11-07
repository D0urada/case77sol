import axios from 'axios';
import { handleFormError, showErrorMessages, clearErrorMessages, showSuccessMessage } from '../../notifications.js';
import { setupMasksListener } from '../../masks.js';

/**
 * Sets up event listeners for the client creation form.
 */
export const setupStoreListener = () => {
    // Sets up event listeners for the form fields.
    setupMasksListener();

    // Captures the client creation form.
    const form = document.getElementById('create-client-form');

    if (form) {
        // Adds the event listener for the form.
        form.addEventListener('submit', handleFormSubmit);
    } else {
        console.error('Formulário de criação de cliente não encontrado!');
    }
};

/**
 * Handles the form submission event.
 * @param {Event} event - The submission event.
 */
async function handleFormSubmit(event) {
    // Prevents the default form behavior.
    event.preventDefault();

    // Captures the submitted form.
    const form = event.target;

    // Calls the function to submit the form via AJAX.
    await submitForm(form);
}

/**
 * Submits the form via AJAX.
 * @param {HTMLFormElement} form - The form that will be submitted.
 */
async function submitForm(form) {
    // Gets the action URL of the form.
    const url = form.action;

    // Creates a FormData object with the form data.
    const formData = new FormData(form);

    try {
        // Sends a POST request to the form URL with the data.
        const response = await axios.post(url, formData, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        // Clears previous error messages.
        clearErrorMessages();

        // Displays the success message received in the response.
        showSuccessMessage(response.data.message);

        // Resets the form.
        form.reset();

        // Reloads the page after 2 seconds.
        setTimeout(() => location.reload(), 2000);
    } catch (error) {
        // Handles form submission errors.
        handleFormError(error);
    }
}
