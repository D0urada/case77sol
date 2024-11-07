<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Providers\BrazilianDocumentsProvider;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    protected BrazilianDocumentsProvider $documentsProvider;

    /**
     * Create a new form request instance.
     *
     * This constructor initializes the form request with a BrazilianDocumentsProvider.
     * It sets up the necessary dependencies for handling Brazilian document validation.
     *
     * @param BrazilianDocumentsProvider $documentsProvider An instance of BrazilianDocumentsProvider.
     */
    public function __construct(BrazilianDocumentsProvider $documentsProvider)
    {
        // Call the parent constructor to ensure proper initialization
        parent::__construct();

        // Assign the documents provider to the instance variable for later use
        $this->documentsProvider = $documentsProvider;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * This method is responsible for determining whether the user has
     * the necessary permissions to perform the action associated with
     * this request. By default, all users are authorized to make this
     * request, as indicated by the return value of true.
     *
     * @return bool True if the user is authorized, otherwise false.
     */
    public function authorize(): bool
    {
        // Authorize all users to make this request
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * This method returns an array of validation rules that are used
     * during the validation process. These rules are used to validate
     * the request data.
     *
     * @return array An array of validation rules.
     */
    public function rules(): array
    {
        $clientId = $this->route('client');

        // Validation rules for the request
        return [
            // CPF/CNPJ must be a unique string of 20 characters
            'cpfcnpj' => [
                'required',
                'string',
                'max:20',
                // Ignore the current client when validating uniqueness
                Rule::unique('clients', 'cpfcnpj')->ignore($this->client, 'id'),
                // Validate if the CPF/CNPJ is valid
                function ($attribute, $value, $fail) {
                    if (!$this->documentsProvider->isValidCpfOrCnpj($value)) {
                        $fail("O $attribute campo deve ser um CPF ou CNPJ válido.");
                    }
                },
            ],
            // Name must be a required string with a maximum of 255 characters
            'name' => 'required|string|max:255',
            // Email must be a required string with a maximum of 255 characters and unique
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Ignore the current client when validating uniqueness
                Rule::unique('clients', 'email')->ignore($this->client, 'id'),
            ],
            // Phone must be an optional string with a maximum of 15 characters
            'phone' => 'nullable|string|max:15',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * This method returns an array of custom error messages that are used
     * during the validation process. These messages correspond to validation
     * rule failures for specific fields in the request. Each key in the array
     * represents a validation rule, and the corresponding value is the error
     * message displayed when that rule fails.
     *
     * @return array<string, string> An array of custom error messages.
     */
    public function messages(): array
    {
        // Return an associative array of validation error messages
        return [
            'cpfcnpj.required' => 'O CPF/CNPJ é obrigatório.', // Message for missing CPF/CNPJ
            'cpfcnpj.unique' => 'O CPF/CNPJ já está em uso.',  // Message for duplicate CPF/CNPJ
            'name.required' => 'O nome é obrigatório.',        // Message for missing name
            'email.required' => 'O e-mail é obrigatório.',     // Message for missing email
            'email.unique' => 'O e-mail já está em uso.',      // Message for duplicate email
        ];
    }
}
