// No seu arquivo show.js
import { setupSearchClienteListener } from './partials/searchCliente.js';
import { setupUpdateListener } from './partials/update.js';
import { loadEquipmentFields } from './partials/equipment.js';

document.addEventListener('DOMContentLoaded', () => {
    // Inicializa equipmentList caso não exista
    window.equipmentList = window.equipmentList || {};

    // Carrega a lista de equipamentos iniciais, caso existam
    const initialEquipmentList = window.initialEquipmentList ? JSON.parse(window.initialEquipmentList) : [];
    initialEquipmentList.forEach(equipment => {
        if (equipment.name && equipment.quantity) {
            window.equipmentList[equipment.name] = equipment.quantity;
        }
    });

    // Carrega os campos de equipamentos
    loadEquipmentFields();
    setupSearchClienteListener();
    setupUpdateListener(initialEquipmentList);
});
