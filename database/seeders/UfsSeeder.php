<?php

namespace Database\Seeders;

use App\Models\Uf;
use Illuminate\Database\Seeder;

class UfsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ufs = [
            ['acronym' => 'AC', 'name' => 'Acre'],
            ['acronym' => 'AL', 'name' => 'Alagoas'],
            ['acronym' => 'AP', 'name' => 'Amapá'],
            ['acronym' => 'AM', 'name' => 'Amazonas'],
            ['acronym' => 'BA', 'name' => 'Bahia'],
            ['acronym' => 'CE', 'name' => 'Ceará'],
            ['acronym' => 'DF', 'name' => 'Distrito Federal'],
            ['acronym' => 'ES', 'name' => 'Espírito Santo'],
            ['acronym' => 'GO', 'name' => 'Goiás'],
            ['acronym' => 'MA', 'name' => 'Maranhão'],
            ['acronym' => 'MT', 'name' => 'Mato Grosso'],
            ['acronym' => 'MS', 'name' => 'Mato Grosso do Sul'],
            ['acronym' => 'MG', 'name' => 'Minas Gerais'],
            ['acronym' => 'PA', 'name' => 'Pará'],
            ['acronym' => 'PB', 'name' => 'Paraíba'],
            ['acronym' => 'PR', 'name' => 'Paraná'],
            ['acronym' => 'PE', 'name' => 'Pernambuco'],
            ['acronym' => 'PI', 'name' => 'Piauí'],
            ['acronym' => 'RJ', 'name' => 'Rio de Janeiro'],
            ['acronym' => 'RN', 'name' => 'Rio Grande do Norte'],
            ['acronym' => 'RS', 'name' => 'Rio Grande do Sul'],
            ['acronym' => 'RO', 'name' => 'Rondônia'],
            ['acronym' => 'RR', 'name' => 'Roraima'],
            ['acronym' => 'SC', 'name' => 'Santa Catarina'],
            ['acronym' => 'SP', 'name' => 'São Paulo'],
            ['acronym' => 'SE', 'name' => 'Sergipe'],
            ['acronym' => 'TO', 'name' => 'Tocantins'],
        ];

        // Insert the UF data into the 'ufs' table
        foreach ($ufs as $uf) {
            Uf::create([
                'acronym' => $uf['acronym'],
                'name' => $uf['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
