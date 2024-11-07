import axios from 'axios';
import { handleFormError, showErrorMessages, clearErrorMessages, showSuccessMessage } from '../../notifications.js';
import { setupMasksListener } from '../../masks.js';


export const setupUpdateListener = () => {
    setupMasksListener();

    const form = document.getElementById('update-client-form');

    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    } else {
        console.error('Formulário de atualização de cliente não encontrado!');
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

        setTimeout(() => location.reload(), 2000);
    } catch (error) {
        handleFormError(error);
    }
}
