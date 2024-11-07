/**
 * import the JS files
 */
import { setupSearchClienteListener } from './partials/searchCliente.js';
import { setupStoreListener } from './partials/store.js';

document.addEventListener('DOMContentLoaded', () => {
    setupSearchClienteListener();
    setupStoreListener();
});

