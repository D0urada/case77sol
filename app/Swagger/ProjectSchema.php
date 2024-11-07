<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="Project",
 *     type="object",
 *     required={"name", "description", "client_id", "location_uf", "installation_type", "equipment"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the project",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the project",
 *         example="Project Alpha"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="A description of the project",
 *         example="This project involves the installation of solar panels."
 *     ),
 *     @OA\Property(
 *         property="client_id",
 *         type="integer",
 *         description="The ID of the client associated with the project",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="location_uf",
 *         type="string",
 *         description="The state (UF) where the project is located",
 *         example="SP"
 *     ),
 *     @OA\Property(
 *         property="installation_type",
 *         type="string",
 *         description="The type of installation for the project",
 *         example="Solar Panel"
 *     ),
 *     @OA\Property(
 *         property="equipment",
 *         type="array",
 *         description="The list of equipment used in the project",
 *         @OA\Items(
 *             type="string",
 *             example="Solar Panels"
 *         )
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The date when the project was created",
 *         example="2024-01-01T00:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The date when the project was last updated",
 *         example="2024-01-10T00:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="client",
 *         ref="#/components/schemas/Client",
 *         description="The client associated with the project"
 *     )
 * )
 */
class ProjectSchema
{
    // O Swagger irá processar essas anotações.
}
