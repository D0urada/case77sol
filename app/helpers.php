<?php

if (! function_exists('applyCpfCnpjMask'))
{
    /**
     * Apply a mask to a CPF or CNPJ value.
     *
     * This function formats a given CPF or CNPJ value by adding
     * the appropriate mask. The function assumes the input is
     * a numeric string with or without existing formatting.
     *
     * @param string $value The CPF or CNPJ value to be masked.
     * @return string The masked CPF or CNPJ value.
     */
    function applyCpfCnpjMask(string $value): string
    {
        // Remove all non-numeric characters from the input
        $value = preg_replace('/\D/', '', $value);

        // Apply CPF mask if the value is 11 digits long
        if (strlen($value) <= 11) {
            $value = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $value);
        } else { // Apply CNPJ mask if the value is longer
            $value = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $value);
        }

        return $value; // Return the masked value
    }
}


if (! function_exists('removeCpfCnpjMask'))
{
    /**
     * Remove the mask from a CPF or CNPJ value.
     *
     * This function removes all non-numeric characters from a CPF or CNPJ value,
     * returning only the digits. It is useful for normalizing CPF or CNPJ values
     * before validation or storage.
     *
     * @param string $inputValue The CPF or CNPJ value with or without a mask.
     * @return string The CPF or CNPJ value without the mask, or an empty string if the format is invalid.
     */
    function removeCpfCnpjMask(string $inputValue): string
    {
        // Remove all non-numeric characters from the input
        $numericValue = preg_replace('/\D/', '', $inputValue);

        // Check if the numeric value has a valid length for CPF or CNPJ
        // CPF: 11 digits
        // CNPJ: 14 digits
        if (strlen($numericValue) === 11 || strlen($numericValue) === 14) {
            return $numericValue; // Return the unmasked numeric value
        }

        // If the numeric value has an invalid length, return the original string
        return $inputValue;
    }
}

if (! function_exists('detectCpfOrCnpj'))
{
    /**
     * Detect if the given value is a CPF or CNPJ.
     *
     * This function takes a string value and checks if it is a valid CPF or CNPJ.
     * It returns 'CPF' if the value is a valid CPF, 'CNPJ' if it is a valid CNPJ,
     * or false if it is neither.
     *
     * @param string $value The value to check.
     * @return string|bool 'CPF' if the value is a valid CPF, 'CNPJ' if it is a valid CNPJ, or false if it is neither.
     */
    function detectCpfOrCnpj(string $value): string|bool
    {
        // Remove all non-numeric characters from the input
        $numericValue = preg_replace('/\D/', '', $value);

        // Check if the numeric value has a valid length for CPF or CNPJ
        if (strlen($numericValue) === 11) {
            return 'CPF'; // Return 'CPF' if the value is a valid CPF
        } elseif (strlen($numericValue) === 14) {
            return 'CNPJ'; // Return 'CNPJ' if the value is a valid CNPJ
        }

        return false; // Return false if the format is invalid
    }
}
