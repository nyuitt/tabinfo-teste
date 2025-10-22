<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="TabInfo API",
 *     description="API REST para gerenciamento de usuários com autenticação Sanctum",
 *     @OA\Contact(
 *         email="contato@tabinfo.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor de desenvolvimento"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Token de autenticação Sanctum (Bearer token)"
 * )
 */
abstract class Controller
{
    //
}
