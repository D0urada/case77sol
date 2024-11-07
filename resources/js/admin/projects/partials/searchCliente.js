import axios from 'axios';
import { showErrorMessages, clearErrorMessages } from '../../notifications.js';

export const setupSearchClienteListener = () => {
    const clientSearch = document.getElementById('client_search');
    if (clientSearch) {
        clientSearch.addEventListener('input', handleFormSearch);
    }
};

async function handleFormSearch() {
    const query = this.value.trim();

    if (query.length >= 3) {
        try {
            const response = await axios.get(`/admin/clients/search`, { params: { q: query } });
            const clients = response.data;

            updateClientSelect(clients);
        } catch (error) {
            console.error("Erro ao buscar clientes:", error);
            showErrorMessages("Erro ao buscar clientes. Tente novamente.");
        }
    } else {
        clearClientSelect();
    }
}

function updateClientSelect(clients) {
    const clientSelect = document.getElementById('client_id');
    clientSelect.innerHTML = '<option value="">Selecione um cliente</option>';

    if (clients.length > 0) {
        clients.forEach(client => {
            const option = document.createElement('option');
            option.value = client.id;
            option.textContent = `${client.name} - ${client.email}`;
            clientSelect.appendChild(option);
        });
    } else {
        const option = document.createElement('option');
        option.value = "";
        option.textContent = "Nenhum cliente encontrado";
        clientSelect.appendChild(option);
    }
}

function clearClientSelect() {
    const clientSelect = document.getElementById('client_id');
    clientSelect.innerHTML = '<option value="">Selecione um cliente</option>';
}
