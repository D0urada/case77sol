<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="Client",
 *     type="object",
 *     required={"cpfcnpj", "name", "email", "phone"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the client",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="cpfcnpj",
 *         type="string",
 *         description="The CPF or CNPJ of the client",
 *         example="12345678901"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the client",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="The email address of the client",
 *         example="johndoe@example.com"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="The phone number of the client",
 *         example="+123456789"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The date when the client was created",
 *         example="2024-01-01T00:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The date when the client was last updated",
 *         example="2024-01-10T00:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="projects",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Project")
 *     )
 * )
 */
class ClientSchema
{
    // O Swagger irá processar essas anotações.
}
