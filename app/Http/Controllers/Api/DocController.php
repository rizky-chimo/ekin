<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *     title="API Dokumentasi E-KIN",
 *     version="1.0.0",
 *     description="Dokumentasi semua endpoint API E-KIN"
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Localhost"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Masukkan token tanpa kata Bearer, contoh: 12345abcdef"
 * )
 */
class DocController
{
    // kosong
}
