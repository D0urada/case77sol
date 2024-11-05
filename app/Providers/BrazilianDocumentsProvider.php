<?php

namespace App\Providers;

use Faker\Provider\Base as BaseProvider;

class BrazilianDocumentsProvider extends BaseProvider
{
    /**
     * Generate a valid CPF (Brazilian personal ID).
     *
     * @return string A valid CPF number.
     */
    public function cpf(): string
    {
        return $this->generateCpfOrCnpj(11);
    }

    /**
     * Generate a valid CNPJ (Brazilian company ID).
     *
     * @return string A valid CNPJ number.
     */
    public function cnpj(): string
    {
        return $this->generateCpfOrCnpj(14);
    }

    /**
     * Check if a CPF/CNPJ is valid.
     *
     * @param  string  $cpfCnpj  The CPF or CNPJ number to be validated.
     * @return bool  True if the CPF/CNPJ is valid, false otherwise.
     */
    public function isValidCpfOrCnpj(string $cpfCnpj): bool
    {
        $cpfCnpj = preg_replace('/\D/', '', $cpfCnpj);

        if (strlen($cpfCnpj) === 11) {
            return $this->validateCpf($cpfCnpj);
        }

        if (strlen($cpfCnpj) === 14) {
            return $this->validateCnpj($cpfCnpj);
        }

        return false;
    }

    /**
     * Generate a valid CPF or CNPJ number.
     *
     * @param int $length The length of the document to generate (11 for CPF, 14 for CNPJ).
     * @return string A valid CPF or CNPJ number.
     */
    private function generateCpfOrCnpj(int $length): string
    {
        $n = array_map(fn() => rand(0, 9), range(1, $length - 2));

        if ($length === 11) {
            $n[] = $this->calculateCpfDigit($n, 10);
            $n[] = $this->calculateCpfDigit($n, 11);
        } elseif ($length === 14) {
            $n[] = $this->calculateCnpjDigit($n, [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);
            $n[] = $this->calculateCnpjDigit($n, [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);
        }

        return implode('', $n);
    }

    /**
     * Validate a CPF (Brazilian personal ID).
     *
     * @param string $cpf The CPF to validate.
     * @return bool True if the CPF is valid, false otherwise.
     */
    private function validateCpf(string $cpf): bool
    {
        $cpfDigits = array_map('intval', str_split($cpf));
        return $cpfDigits[9] === $this->calculateCpfDigit($cpfDigits, 10) &&
               $cpfDigits[10] === $this->calculateCpfDigit($cpfDigits, 11);
    }

    /**
     * Validate a CNPJ (Brazilian company ID).
     *
     * @param string $cnpj The CNPJ to validate.
     * @return bool True if the CNPJ is valid, false otherwise.
     */
    private function validateCnpj(string $cnpj): bool
    {
        $cnpjDigits = array_map('intval', str_split($cnpj));

        $firstDigit = $this->calculateCnpjDigit($cnpjDigits, [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);
        $secondDigit = $this->calculateCnpjDigit($cnpjDigits, [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);

        return $cnpjDigits[12] === $firstDigit && $cnpjDigits[13] === $secondDigit;
    }

    /**
     * Calculate a digit for CPF (Brazilian personal ID).
     *
     * This function calculates a verification digit for a CPF number
     * based on the provided weights.
     *
     * @param array $n The array of CPF digits.
     * @param int   $weight The initial weight for the calculation.
     * @return int The calculated CPF digit.
     */
    private function calculateCpfDigit(array $n, int $weight): int
    {
        $sum = 0;
        for ($i = 0; $i < $weight - 1; $i++) {
            $sum += $n[$i] * ($weight - $i);
        }

        $remainder = $sum % 11;

        return $remainder < 2 ? 0 : 11 - $remainder;
    }

    /**
     * Calculate a digit for CNPJ (Brazilian company ID).
     *
     * This function calculates a verification digit for a CNPJ number
     * based on the provided weights.
     *
     * @param array $n The array of CNPJ digits.
     * @param array $weights The weights for the calculation.
     * @return int The calculated CNPJ digit.
     */
    private function calculateCnpjDigit(array $n, array $weights): int
    {
        $sum = 0;
        for ($i = 0; $i < count($weights); $i++) {
            $sum += $n[$i] * $weights[$i];
        }

        $remainder = $sum % 11;

        return $remainder < 2 ? 0 : 11 - $remainder;
    }
}
