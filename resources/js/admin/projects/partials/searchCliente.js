import axios from 'axios';
import { showErrorMessages, clearErrorMessages } from '../../notifications.js';

/**
 * Initializes the search client listener.
 *
 * This function sets up an event listener on the search input field
 * to handle user input and trigger the search functionality.
 */
export const setupSearchClienteListener = () => {
    // Get the search input field for clients
    const clientSearch = document.getElementById('client_search');

    if (clientSearch) {
        // Trim and store the initial value of the input field
        const initialValue = clientSearch.value.trim();

        // If there's an initial value, perform the search immediately
        if (initialValue) {
            handleFormSearch(initialValue);
        }

        // Add an event listener to handle input changes
        clientSearch.addEventListener('input', (e) => handleFormSearch(e.target.value));
    }
};

/**
 * Handles the client search form input.
 * @param {string} query - The search query input by the user.
 */
async function handleFormSearch(query) {
    // Trim the input query and ensure it's a string
    query = String(query).trim();

    // Check if the query is at least 3 characters long or is a valid CPF/CNPJ
    if (query.length >= 3 || isCpfCnpj(query)) {
        try {
            // Perform an AJAX request to search for clients based on the query
            const response = await axios.get(`/admin/clients/search`, { params: { q: query } });
            const clients = response.data;

            // Update the client select dropdown with the search results
            updateClientSelect(clients);

            // Automatically select the client if only one result is returned
            if (clients.length === 1) {
                document.getElementById('client_id').value = clients[0].id;
            }
        } catch (error) {
            // Log the error and display an error message to the user
            console.error("Erro ao buscar clientes:", error);
            showErrorMessages("Erro ao buscar clientes. Tente novamente.");
        }
    } else {
        // Clear the client selection if the query is invalid
        clearClientSelect();
    }
}

/**
 * Verifica se o valor  um CPF ou CNPJ.
 * @param {string} value - O valor a ser verificado.
 * @returns {boolean} - Verdadeiro se o valor for um CPF ou CNPJ, falso caso contr rio.
 */
function isCpfCnpj(value) {
    const cpfPattern = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/; // xxx.xxx.xxx-xx
    const cnpjPattern = /^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/; // xx.xxx.xxx/xxxx-xx
    return cpfPattern.test(value) || cnpjPattern.test(value);
}

/**
 * Updates the client select dropdown with the search results.
 * @param {array} clients - The array of clients returned from the search.
 */
function updateClientSelect(clients) {
    const clientSelect = document.getElementById('client_id');
    clientSelect.innerHTML = '<option value="">Selecione um cliente</option>';

    if (clients.length > 0) {
        // Iterate over the clients array and create an option for each client
        clients.forEach(client => {
            const option = document.createElement('option');
            option.value = client.id;
            option.textContent = `${client.name} - ${client.email}`;
            clientSelect.appendChild(option);
        });
    } else {
        // If no clients are found, add an option indicating that
        const option = document.createElement('option');
        option.value = "";
        option.textContent = "Nenhum cliente encontrado";
        clientSelect.appendChild(option);
    }
}

/**
 * Clears the client select dropdown.
 */
function clearClientSelect() {
    const clientSelect = document.getElementById('client_id');
    // Reset the client select to its initial state
    clientSelect.innerHTML = '<option value="">Selecione um cliente</option>';
}
