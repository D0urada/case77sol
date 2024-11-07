<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Client;
use App\Models\InstallationType;
use App\Models\Uf;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool Returns true if the user is authorized.
     */
    public function authorize(): bool
    {
        // For now, all users are authorized to make this request.
        return true;
    }

    public function prepareForValidation()
    {
        // Converte o campo 'equipment' para um array se estiver no formato JSON
        if ($this->has('equipment')) {
            $this->merge([
                'equipment' => json_decode($this->input('equipment'), true),
            ]);
        }
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
        return [
            // The name is required and must be a string with a maximum of 255
            // characters.
            'name' => 'required|string|max:255',
            // The description is optional but must be a string if provided.
            'description' => 'nullable|string',
            // The client_id is required and must be the ID of an existing client.
            'client_id' => [
                'required',
                'exists:clients,id',
            ],
            // The installation type is required and must be one of the installation
            // types defined in the InstallationType model.
            'installation_type' => [
                'required',
                'string',
                'in:' . implode(',', InstallationType::pluck('name')->toArray()),
            ],
            // The location_uf is required and must be a two character string that is
            // the acronym of a valid UF.
            'location_uf' => [
                'required',
                'string',
                'size:2',
                'in:' . implode(',', Uf::pluck('acronym')->toArray()),
            ],
            // Ensures that "equipment" is an array
            'equipment' => 'required|array',
            // Checks if the equipment name is valid
            'equipment.*.name' => 'required|string|exists:equipment,name',
            // Checks the quantity of each equipment
            'equipment.*.quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * This method returns an array of custom error messages. The key of each
     * item in the array is the name of the validation rule, and the value is the
     * custom error message.
     *
     * @return array<string, string> An array of custom error messages.
     */
    public function messages(): array
    {
        return [
            // The project name is required
            'name.required' => 'O nome do projeto é obrigatório.',

            // The client is required
            'client_id.required' => 'O cliente é obrigatório.',

            // The selected client does not exist
            'client_id.exists' => 'O cliente selecionado não existe.',

            // The installation type is required
            'installation_type.required' => 'O tipo de instalação é obrigatório.',

            // The selected installation type is invalid
            'installation_type.in' => 'O tipo de instalação selecionado é inválido.',

            // The UF is required
            'location_uf.required' => 'A UF é obrigatória.',

            // The UF must have exactly 2 characters
            'location_uf.size' => 'A UF deve ter exatamente 2 caracteres.',

            // The selected UF is invalid
            'location_uf.in' => 'A UF selecionada é inválida.',

            // The equipment list is required
            'equipment.required' => 'A lista de equipamentos é obrigatória.',

            // The equipment list must be an array
            'equipment.array' => 'A lista de equipamentos deve ser um array.',

            // Each equipment name is required
            'equipment.*.name.required' => 'O nome do equipamento é obrigatório.',

            // The equipment name needs to be valid
            'equipment.*.name.exists' => 'O equipamento selecionado não existe.',

            // The equipment quantity is required
            'equipment.*.quantity.required' => 'A quantidade do equipamento é obrigatória.',

            // The equipment quantity must be an integer
            'equipment.*.quantity.integer' => 'Cada quantidade de equipamento deve ser um número inteiro.',

            // The equipment quantity must be greater than 0
            'equipment.*.quantity.min' => 'Cada quantidade de equipamento deve ser maior que 0.',
        ];
    }
}
