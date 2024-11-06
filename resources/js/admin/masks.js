/**
 * Configura os ouvintes de evento para os botões de deletação.
 */
export const setupMasksListener = () => {
    const cpfCnpjInput = document.getElementById('cpfcnpj');
    const phoneInput = document.getElementById('phone');

    if (cpfCnpjInput) {
        cpfCnpjInput.addEventListener('input', applyCpfCnpjMask);
        cpfCnpjInput.addEventListener('paste', handlePaste);
    }

    if (phoneInput) {
        phoneInput.addEventListener('input', applyPhoneMask);
    }
};

/**
 * Aplica a máscara de CPF ou CNPJ no valor do input.
 * @param {Event} e - O evento de input.
 */
function applyCpfCnpjMask(e) {
    let value = e.target.value.replace(/\D/g, '');

    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{2})$/, '$1-$2');
    } else {
        value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5');
    }

    e.target.value = value;

    const pattern = new RegExp('^(\\d{3}\\.\\d{3}\\.\\d{3}-\\d{2}|\\d{2}\\.\\d{3}\\.\\d{3}/\\d{4}-\\d{2})$');
    e.target.setCustomValidity(pattern.test(value) ? '' : 'Formato inválido');
}

/**
 * Manipula o evento de colar e aplica a máscara após.
 * @param {Event} e - Evento de colagem.
 */
function handlePaste(e) {
    setTimeout(() => {
        applyCpfCnpjMask(e);
    }, 0);
}

/**
 * Aplica a máscara de telefone.
 * @param {Event} e - Evento de input.
 */
function applyPhoneMask(e) {
    let value = e.target.value.replace(/\D/g, '');

    if (value.length <= 10) {
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{4})(\d)/, '$1-$2');
    } else {
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
    }

    e.target.value = value;
}
