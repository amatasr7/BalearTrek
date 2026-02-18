<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    // Aquí van las rutas que quieres habilitar (normalmente todas las de la API)
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Aquí van los verbos HTTP permitidos. '*' significa todos (GET, POST, PUT, DELETE, etc.)
    'allowed_methods' => ['*'],

    // Esto está bien, usa tu variable de entorno o el puerto por defecto de Vite
    'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:5173')],

    'allowed_origins_patterns' => [],

    // Permite que React envíe cabeceras como 'Content-Type' y 'Authorization'
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];