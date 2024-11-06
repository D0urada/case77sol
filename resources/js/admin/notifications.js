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
 * Limpa as mensagens de erro do formulário.
 */
export function clearErrorMessages() {
    document.querySelectorAll('.error-message').forEach(el => el.remove());
}

/**
 * Exibe a mensagem de sucesso após o envio do formulário.
 * @param {string} message - Mensagem de sucesso.
 */
export function showSuccessMessage(message) {
    const alertDiv = document.getElementById('alert-success');
    const alertMessage = document.getElementById('alert-message');

    if (alertDiv && alertMessage) {
        alertMessage.textContent = message;
        alertDiv.classList.remove('hidden');
        alertDiv.classList.add('opacity-100');

        setTimeout(() => {
            alertDiv.classList.add('opacity-0');
            alertDiv.classList.remove('opacity-100');
        }, 1500);
    }
}

/**
 * Trata erros de envio do formulário.
 * @param {Error} error - O erro ocorrido durante a submissão.
 */
export function handleFormError(error) {
    if (error.response && error.response.data.errors) {
        showErrorMessages(error.response.data.errors);
    } else {
        console.error('Erro ao submeter o formulário:', error);
    }
}
