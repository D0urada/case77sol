/**
 * Exibe as mensagens de erro no formulário.
 * @param {Object} errors - Objeto com mensagens de erro por campo.
 */
export function showErrorMessages(errors) {
    clearErrorMessages();

    for (const [field, messages] of Object.entries(errors)) {
        const inputField = document.querySelector(`[name="${field}"]`);

        if (inputField) {
            messages.forEach(message => {
                const errorMessage = document.createElement('span');
                errorMessage.classList.add('error-message', 'text-red-500', 'text-sm');
                errorMessage.textContent = message;
                inputField.parentNode.appendChild(errorMessage);
            });
        }
    }
}


/**
 * Remove as mensagens de erro do formul rio.
 */
export function clearErrorMessages() {
    // Seleciona todos os elementos com a classe 'error-message'
    const errorMessages = document.querySelectorAll('.error-message');

    // Remove todos os elementos encontrados
    errorMessages.forEach(el => el.remove());
}

/**
 * Displays a success message in an alert element.
 * @param {string} message - The success message to display.
 */
export function showSuccessMessage(message) {
    // Get the alert div and message elements by their IDs
    const alertDiv = document.getElementById('alert-success');
    const alertMessage = document.getElementById('alert-message');

    // Check if the alert elements exist
    if (alertDiv && alertMessage) {
        // Set the text content of the alert message
        alertMessage.textContent = message;

        // Show the alert div by removing the 'hidden' class and adding 'opacity-100'
        alertDiv.classList.remove('hidden');
        alertDiv.classList.add('opacity-100');

        // After 1.5 seconds, fade out the alert by adding 'opacity-0' and removing 'opacity-100'
        setTimeout(() => {
            alertDiv.classList.add('opacity-0');
            alertDiv.classList.remove('opacity-100');
        }, 1500);
    }
}


/**
 * Handles any errors that occur when submitting the form.
 * @param {Error} error - The error object thrown by the form submission.
 */
export function handleFormError(error) {
    // If the error object contains a response property with a data property containing errors,
    // show the error messages on the form.
    if (error.response && error.response.data.errors) {
        showErrorMessages(error.response.data.errors);
    } else {
        // Log the error to the console.
        console.error('Erro ao submeter o formulário:', error);
    }
}
