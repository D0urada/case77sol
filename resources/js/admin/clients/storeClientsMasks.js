document.addEventListener('DOMContentLoaded', () => {
    const cpfCnpjInput = document.getElementById('cpfcnpj');
    const phoneInput = document.getElementById('phone');

    /**
     * Function to apply CPF/CNPJ mask to the input value.
     * @param {Event} e - The input event.
     */
    const applyCpfCnpjMask = (e) => {
        let value = e.target.value;

        // If the value is already formatted correctly, do nothing
        if (value.match(/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$|^\d{3}\.\d{3}\.\d{3}-\d{2}$/)) {
            return; // Exit if the value is already formatted
        }

        // Remove non-numeric characters
        value = value.replace(/\D/g, '');

        if (value.length <= 11) { // CPF formatting
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{2})$/, '$1-$2'); 
        } else if (value.length >= 12) { // CNPJ formatting
            value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5');
        } else if (value.length > 8) {
            value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4');
        } else if (value.length > 5) {
            value = value.replace(/^(\d{2})(\d{3})(\d{2})$/, '$1.$2-$3');
        } else if (value.length > 2) {
            value = value.replace(/^(\d{2})(\d{1,2})$/, '$1.$2');
        }

        // Update the input value with the formatted mask
        e.target.value = value;

        // Validate if the final mask matches the correct pattern
        const pattern = new RegExp('^(\\d{3}\\.\\d{3}\\.\\d{3}-\\d{2}|\\d{2}\\.\\d{3}\\.\\d{3}/\\d{4}-\\d{2})$');
        if (!pattern.test(value)) {
            e.target.setCustomValidity('Invalid format'); // Set custom error message
        } else {
            e.target.setCustomValidity(''); // Clear error message if format is correct
        }
    };

    /**
     * Function to handle the paste event and apply the CPF/CNPJ mask after it.
     * @param {Event} e - The paste event.
     */
    const handlePaste = (e) => {
        // Applies the mask after pasting with a tiny delay
        setTimeout(() => {
            applyCpfCnpjMask(e); // Applies the mask after pasting
        }, 0);
    };

    /**
     * Function to apply a phone mask to the input value.
     * @param {Event} e - The input event.
     */
    const applyPhoneMask = (e) => {
        // Remove non-numeric characters from the input value
        let value = e.target.value.replace(/\D/g, ''); 

        // Apply mask for phone numbers with up to 10 digits (e.g., landline format)
        if (value.length <= 10) {
            value = value.replace(/(\d{2})(\d)/, '($1) $2'); // Format: (XX) X
            value = value.replace(/(\d{4})(\d)/, '$1-$2');   // Format: (XX) XXXX-XXXX
        } else {
            // Apply mask for phone numbers with more than 10 digits (e.g., mobile format)
            value = value.replace(/(\d{2})(\d)/, '($1) $2'); // Format: (XX) X
            value = value.replace(/(\d{5})(\d)/, '$1-$2');   // Format: (XX) XXXXX-XXXX
        }

        // Update the input value with the formatted phone number
        e.target.value = value; 
    };

    // Adds event listeners
    if (cpfCnpjInput) {
        cpfCnpjInput.addEventListener('input', applyCpfCnpjMask);
        cpfCnpjInput.addEventListener('paste', handlePaste);
    }

    if (phoneInput) {
        phoneInput.addEventListener('input', applyPhoneMask);
    }
});
