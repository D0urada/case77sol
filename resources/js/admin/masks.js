
/**
 * Sets up the event listeners for the form masks.
 *
 * This function sets up event listeners on the CPF/CNPJ and phone fields
 * to handle user input and apply the respective masks.
 */
export const setupMasksListener = () => {
    /**
     * Captures the CPF/CNPJ input field.
     */
    const cpfCnpjInput = document.getElementById('cpfcnpj');

    /**
     * Captures the phone input field.
     */
    const phoneInput = document.getElementById('phone');

    /**
     * Adds event listeners for the CPF/CNPJ input field.
     */
    if (cpfCnpjInput) {
        /**
         * Listens for input events on the CPF/CNPJ field and applies the mask.
         */
        cpfCnpjInput.addEventListener('input', applyCpfCnpjMask);

        /**
         * Listens for paste events on the CPF/CNPJ field and applies the mask after.
         */
        cpfCnpjInput.addEventListener('paste', handlePaste);
    }

    /**
     * Adds event listeners for the phone input field.
     */
    if (phoneInput) {
        /**
         * Listens for input events on the phone field and applies the mask.
         */
        phoneInput.addEventListener('input', applyPhoneMask);
    }
};


/**
 * Applies a mask to the CPF/CNPJ input field value.
 *
 * This function formats the input value as either a CPF or CNPJ depending
 * on the length of the numeric input. It also sets a custom validity message
 * if the input does not match the expected format.
 *
 * @param {Event} e - The input event triggered on the CPF/CNPJ field.
 */
function applyCpfCnpjMask(e) {
    // Remove all non-digit characters from the input value
    let value = e.target.value.replace(/\D/g, '');

    // Determine if the value is a CPF or CNPJ based on its length
    if (value.length <= 11) {
        // Format as CPF: xxx.xxx.xxx-xx
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{2})$/, '$1-$2');
    } else {
        // Format as CNPJ: xx.xxx.xxx/xxxx-xx
        value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5');
    }

    // Update the input field with the formatted value
    e.target.value = value;

    // Set custom validity based on whether the value matches CPF or CNPJ formats
    const pattern = new RegExp('^(\\d{3}\\.\\d{3}\\.\\d{3}-\\d{2}|\\d{2}\\.\\d{3}\\.\\d{3}/\\d{4}-\\d{2})$');
    e.target.setCustomValidity(pattern.test(value) ? '' : 'Formato inválido');
}


/**
 * Handles paste events on the CPF/CNPJ input field.
 *
 * This function sets a short timeout to wait for the browser to finish
 * pasting the content into the input field and then triggers the mask
 * application function.
 *
 * @param {Event} e - The paste event triggered on the CPF/CNPJ field.
 */
function handlePaste(e) {
    setTimeout(() => {
        applyCpfCnpjMask(e);
    }, 0);
}

/**
 * Applies a phone number mask to the input field value.
 *
 * This function formats the input value as a phone number
 * with a pattern of (XX) XXXX-XXXX or (XX) XXXXX-XXXX based
 * on the length of the numeric input.
 *
 * @param {Event} e - The input event triggered on the phone field.
 */
function applyPhoneMask(e) {
    // Remove all non-digit characters from the input value
    let value = e.target.value.replace(/\D/g, '');

    if (value.length <= 10) {
        // Format as (XX) XXXX-XXXX for numbers with up to 10 digits
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{4})(\d)/, '$1-$2');
    } else {
        // Format as (XX) XXXXX-XXXX for numbers with more than 10 digits
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
    }

    // Update the input field value with the formatted phone number
    e.target.value = value;
}
