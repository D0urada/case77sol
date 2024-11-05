document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('create-client-form'); // Selects the form directly

    if (form) {
        // Adds the submit listener when the DOM is loaded
        form.addEventListener('submit', handleFormSubmit);
    } else {
        console.error('Formulário não encontrado no modal!');
    }
});

/**
 * Function to handle the form submission.
 * @param {Event} event - The form submission event.
 * Handles the form submission and prevents the normal form submission,
 * calling the submitForm function to send the form data via AJAX.
 */
async function handleFormSubmit(event) {
    event.preventDefault(); // Prevents the normal form submission
    const form = event.target; // Gets the form that triggered the event
    await submitForm(form); // Calls the submit function
}

/**
 * Function to submit the form via AJAX using Axios.
 * @param {HTMLFormElement} form - The form to be submitted.
 * @returns {Promise<void>}
 */
async function submitForm(form) {
    const url = form.action; // URL of the form
    const formData = new FormData(form); // Collects the form data

    // Axios configuration
    const config = {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
    };

    try {
        // Submits the form to the server using Axios
        const response = await axios.post(url, formData, config);

        // Clears previous error messages
        document.querySelectorAll('.error-message').forEach(el => el.remove());

        // Calls the function to display the success message
        showSuccessMessage(response.data.message);
        
        // Reset the form
        form.reset(); 

        // Waits 10 seconds before refreshing the page
        setTimeout(() => {
            location.reload();
        }, 5000); // 5000 milliseconds = 5 seconds

    } catch (error) {
        // Display error messages on the form
        if (error.response && error.response.data.errors) {
            showErrorMessages(error.response.data.errors);
        } else {
            console.error('Error submitting the form:', error);
        }
    }
}


/**
 * Displays error messages on the form.
 * @param {Object} errors - Object containing error messages for each field.
 * @example
 *  {
 *      'name': ['This field is required.'],
 *      'email': ['This email is already taken.', 'The email must be a valid email address.']
 *  }
 */
function showErrorMessages(errors) {
    // Clears previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.remove());

    // Iterates over the errors object and adds the error messages to the form
    for (const [field, messages] of Object.entries(errors)) {
        const inputField = document.querySelector(`[name="${field}"]`);

        // Checks if the input field exists before adding the error messages
        if (inputField) {
            messages.forEach(message => {
                const errorMessage = document.createElement('span');
                errorMessage.classList.add('error-message', 'text-red-500', 'text-sm');
                errorMessage.textContent = message;
                inputField.parentNode.appendChild(errorMessage);
            });
        }
    }
}

/**
 * Displays a success message with a visual alert.
 * @param {string} message - The success message.
 */
function showSuccessMessage(message) {
    /**
     * Selects the alert div and the message span.
     * @type {HTMLElement}
     */
    const alertDiv = document.getElementById('alert-success');
    const alertMessage = document.getElementById('alert-message');

    /**
     * Checks if the elements exist before updating the message.
     */
    if (alertDiv && alertMessage) {
        /**
         * Updates the message text.
         */
        alertMessage.textContent = message;

        /**
         * Shows the message with a fade-in animation.
         */
        alertDiv.classList.remove('hidden'); // Shows the message
        alertDiv.classList.add('opacity-100'); // Adds class to animate visibility
        alertDiv.classList.remove('opacity-0');

        /**
         * Hides the message after 3 seconds.
         */
        setTimeout(() => {
            alertDiv.classList.add('opacity-0'); // Hides the message
            alertDiv.classList.remove('opacity-100');
        }, 3000); // 3 seconds
    }
}
