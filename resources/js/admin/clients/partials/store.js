import axios from 'axios';
import { handleFormError, showErrorMessages, clearErrorMessages, showSuccessMessage } from '../../notifications.js';
import { setupMasksListener } from '../../masks.js';


export const setupStoreListener = () => {
    setupMasksListener();

    const form = document.getElementById('create-client-form');

    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    } else {
        console.error('Formulário de criação de cliente não encontrado!');
    }
};

async function handleFormSubmit(event) {
    event.preventDefault();
    const form = event.target;
    await submitForm(form);
}


async function submitForm(form) {
    const url = form.action;
    const formData = new FormData(form);

    try {
        const response = await axios.post(url, formData, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        clearErrorMessages();

        showSuccessMessage(response.data.message);
        form.reset();

        setTimeout(() => location.reload(), 2000);
    } catch (error) {
        handleFormError(error);
    }
}
