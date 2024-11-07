<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Providers\BrazilianDocumentsProvider;

class StoreClientRequest extends FormRequest
{
	protected BrazilianDocumentsProvider $documentsProvider;

	/**
     * Create a new form request instance.
     *
     * @param BrazilianDocumentsProvider $documentsProvider The provider for the brazilian documents.
     */
    public function __construct(BrazilianDocumentsProvider $documentsProvider)
    {
        parent::__construct();
        $this->documentsProvider = $documentsProvider;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * This method always returns true, so that any request can be validated.
     * The authorization is handled by the middleware, before the request
     * reaches this class.
     *
     * @return bool Always true.
     */
    public function authorize(): bool
    {
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

        return [
            'cpfcnpj' => [
                // The CPFCNPJ is required.
                'required',
                // The CPFCNPJ must be a string.
                'string',
                // The CPFCNPJ must not be longer than 20 characters.
                'max:20',
                // The CPFCNPJ must be unique. If there is an existing client with
                // the same CPFCNPJ, the validation will fail.
                'unique:clients,cpfcnpj,' . $clientId,
                // The CPFCNPJ is validated using the BrazilianDocumentsProvider.
                function($attribute, $value, $fail) {
                    if (!$this->documentsProvider->isValidCpfOrCnpj($value))  {
                        // If the CPFCNPJ is not valid, a message is added to the
                        // validation errors.
                        $fail("O $attribute campo deve ser um CPF ou CNPJ válido.");
                    }
                },
            ],
            'name' => [
                // The name is required.
                'required',
                // The name must be a string.
                'string',
                // The name must not be longer than 255 characters.
                'max:255',
            ],
            'email' => [
                // The email is required.
                'required',
                // The email must be an email.
                'email',
                // The email must be unique. If there is an existing client with
                // the same email, the validation will fail.
                'unique:clients,email,' . $clientId,
            ],
            'phone' => [
                // The phone is not required.
                'nullable',
                // The phone must be a string.
                'string',
                // The phone must not be longer than 15 characters.
                'max:15',
            ],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * This method returns an array of custom error messages that are used
     * during the validation process. These messages correspond to validation
     * rule failures for specific fields in the request.
     *
     * @return array<string, string> An array of custom error messages.
     */
    public function messages(): array
    {
        // This array contains custom error messages for validator errors.
        return [
            // The CPF/CNPJ is required.
            'cpfcnpj.required' => 'O CPF/CNPJ é obrigatório.',
            // The CPF/CNPJ must be unique. If there is an existing client with
            // the same CPF/CNPJ, the validation will fail.
            'cpfcnpj.unique' => 'O CPF/CNPJ já está em uso.',
            // The name is required.
            'name.required' => 'O nome é obrigatório.',
            // The email is required.
            'email.required' => 'O e-mail é obrigatório.',
            // The email must be unique. If there is an existing client with
            // the same email, the validation will fail.
            'email.unique' => 'O e-mail já está em uso.',
        ];
    }
}
