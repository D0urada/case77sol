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
     * @param BrazilianDocumentsProvider $documentsProvider
     */
    public function __construct(BrazilianDocumentsProvider $documentsProvider)
    {
        parent::__construct();
        $this->documentsProvider = $documentsProvider;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Allow all requests to be validated.
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
                'required',
                'string',
                'max:20',
                'unique:clients,cpfcnpj,' . $clientId,
                function($attribute, $value, $fail) {
                    if (!$this->documentsProvider->isValidCpfOrCnpj($value))  {
                        $fail("The $attribute field must be a valid CPF or CNPJ.");
                    }
                },
            ],
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $clientId,
            'phone' => 'nullable|string|max:15',
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
        return [
			'cpfcnpj.required' => 'O CPF/CNPJ é obrigatório.',
			'cpfcnpj.unique' => 'O CPF/CNPJ já está em uso.',
			'name.required' => 'O nome é obrigatório.',
			'email.required' => 'O e-mail é obrigatório.',
			'email.unique' => 'O e-mail já está em uso.',
        ];
    }
}
