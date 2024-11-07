<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="StoreProjectRequest",
 *     type="object",
 *     required={"name", "description", "client_id", "installation_type", "location_uf", "equipment"},
 *     @OA\Property(property="name", type="string", description="Nome do projeto"),
 *     @OA\Property(property="description", type="string", description="Descrição do projeto"),
 *     @OA\Property(property="client_id", type="integer", description="ID do cliente"),
 *     @OA\Property(property="installation_type", type="string", description="Tipo de instalação"),
 *     @OA\Property(property="location_uf", type="string", description="Estado de localização"),
 *     @OA\Property(property="equipment", type="string", description="Equipamento usado")
 * )
 */
class StoreProjectRequestSchema
{
    // O Swagger irá processar essas anotações.
}
