import axios from 'axios';
import { showErrorMessages, clearErrorMessages } from '../../notifications.js';

export const setupSearchClienteListener = () => {
    const clientSearch = document.getElementById('client_search');
    if (clientSearch) {
        // Se o campo já contém um valor ao carregar a página, busca o cliente automaticamente
        const initialValue = clientSearch.value.trim();
        if (initialValue) {
            handleFormSearch(initialValue); // Passa o valor diretamente, sem precisar do evento
        }

        // Escuta o evento de input para que a busca aconteça enquanto o usuário digita
        clientSearch.addEventListener('input', (e) => handleFormSearch(e.target.value));
    }
};

async function handleFormSearch(query) {
    // Garantir que query seja uma string e remover espaços extras
    query = String(query).trim();

    if (query.length >= 3 || isCpfCnpj(query)) {
        try {
            const response = await axios.get(`/admin/clients/search`, { params: { q: query } });
            const clients = response.data;

            updateClientSelect(clients);

            // Se encontrar exatamente um cliente, pré-preenche o campo de ID de cliente
            if (clients.length === 1) {
                document.getElementById('client_id').value = clients[0].id;
            }
        } catch (error) {
            console.error("Erro ao buscar clientes:", error);
            showErrorMessages("Erro ao buscar clientes. Tente novamente.");
        }
    } else {
        clearClientSelect();
    }
}

// Verifica se a string é um CPF ou CNPJ válido
function isCpfCnpj(value) {
    const cpfPattern = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;  // Máscara CPF
    const cnpjPattern = /^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/;  // Máscara CNPJ
    return cpfPattern.test(value) || cnpjPattern.test(value);
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
