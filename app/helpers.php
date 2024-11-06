<?php

if (! function_exists('applyCpfCnpjMask')) {
    /**
     * Aplica a máscara de CPF ou CNPJ no valor.
     *
     * @param string $value O valor do CPF ou CNPJ (somente números).
     * @return string O valor formatado com a máscara de CPF ou CNPJ.
     */
    function applyCpfCnpjMask(string $value): string
    {
        // Remove qualquer caractere não numérico
        $value = preg_replace('/\D/', '', $value);

        // Verifica se é um CPF ou CNPJ e aplica a máscara apropriada
        if (strlen($value) <= 11) {
            // Máscara de CPF
            $value = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $value);
        } else {
            // Máscara de CNPJ
            $value = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $value);
        }

        return $value;
    }
}


if (! function_exists('removeCpfCnpjMask')) {
    /**
     * Remove a máscara de CPF ou CNPJ do valor.
     *
     * @param string $value O valor do CPF ou CNPJ com máscara.
     * @return string O valor sem a máscara, contendo apenas os números.
     */
    function removeCpfCnpjMask(string $value): string
    {
        // Remove todos os caracteres não numéricos
        $value = preg_replace('/\D/', '', $value);

        return $value;
    }
}
