import { setupSearchClienteListener } from './partials/searchCliente.js';
import { setupUpdateListener } from './partials/update.js';
import { loadEquipmentFields } from './partials/equipment.js';

document.addEventListener('DOMContentLoaded', () => {
    window.equipmentList = window.equipmentList || {};

    const initialEquipmentList = window.initialEquipmentList ? JSON.parse(window.initialEquipmentList) : [];
    initialEquipmentList.forEach(equipment => {
        if (equipment.name && equipment.quantity) {
            window.equipmentList[equipment.name] = equipment.quantity;
        }
    });

    loadEquipmentFields();
    setupSearchClienteListener();
    setupUpdateListener(initialEquipmentList);
});
