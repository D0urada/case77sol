import axios from 'axios';
import { handleFormError, showErrorMessages, clearErrorMessages, showSuccessMessage } from '../../notifications.js';
import { setupMasksListener } from '../../masks.js';
import { setupEquipmentListener, equipmentList } from './equipment.js';

export const setupUpdateListener = () => {
    setupMasksListener();

    const form = document.getElementById('update-project-form');

    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    } else {
        console.error('Formulário de atualização de projeto não encontrado!');
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

    // Verifica se o campo 'equipment' existe no formulário e tem valor
    const equipmentField = form.querySelector('[name="equipment"]');
    const existingEquipment = equipmentField && equipmentField.value ?
    (() => {
      try {
        return JSON.parse(equipmentField.value);
      } catch (error) {
        console.error('Erro ao analisar o JSON do equipamento:', error);
        return [];  // Retorna um array vazio caso haja erro no JSON
      }
    })()
    : [];

    // Prepare a lista de equipamentos corretamente
    const equipmentData = Object.keys(window.equipmentList).map(equipment => ({
        name: equipment,
        quantity: window.equipmentList[equipment]
    }));

    // Verifique o formato da string antes de enviar
    console.log('Dados de equipamentos a enviar:', equipmentData);

    // Converta para string JSON e adicione ao FormData
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

        setTimeout(() => location.reload(), 2000);
    } catch (error) {
        handleFormError(error);
    }
}
