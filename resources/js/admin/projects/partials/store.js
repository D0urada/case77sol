import axios from 'axios';
import { handleFormError, showErrorMessages, clearErrorMessages, showSuccessMessage } from '../../notifications.js';
import { setupMasksListener } from '../../masks.js';
import { setupEquipmentListener, equipmentList } from './equipment.js';

export const setupStoreListener = () => {
    setupMasksListener();

    const form = document.getElementById('create-project-form');

    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    } else {
        console.error('Formulário de criação de projeto não encontrado!');
    }

    setupEquipmentListener();
};

async function handleFormSubmit(event) {
    event.preventDefault();
    const form = event.target;

    // Captura a URL de action do formulário corretamente
    const formAction = form.action;

    // Cria o FormData
    const formData = new FormData(form);

    // Adiciona a lista de equipamentos no formato array de objetos
    const equipmentData = Object.keys(equipmentList).map(equipment => ({
        name: equipment,
        quantity: equipmentList[equipment]
    }));

    // Adiciona o array de objetos de equipamentos como uma string JSON ao FormData
    formData.append('equipment', JSON.stringify(equipmentData));

    console.log(formData);

    // Envia o formulário via AJAX
    await submitForm(formAction, formData);
}

async function submitForm(formAction, formData) {
    try {
        const response = await axios.post(formAction, formData, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'multipart/form-data',
            },
        });

        clearErrorMessages();
        showSuccessMessage(response.data.message);

        // Usando window.location.href para redirecionar para a rota desejada
        setTimeout(() => {
            window.location.href = '/admin/projects'; // Redireciona para a página de projetos
        }, 2000);
        } catch (error) {
        handleFormError(error);
    }
}
