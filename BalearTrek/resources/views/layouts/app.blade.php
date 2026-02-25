<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Seleccionamos todos los formularios que tengan validación
                const forms = document.querySelectorAll('form');
                
                forms.forEach(form => {
                    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
                    
                    inputs.forEach(input => {
                        // Cuando el campo es inválido
                        input.addEventListener('invalid', function() {
                            this.setCustomValidity('Este campo es obligatorio! y este mensaje es personalizado!');
                        });

                        // Limpiar el mensaje cuando el usuario empieza a escribir
                        input.addEventListener('input', function() {
                            this.setCustomValidity('');
                        });
                    });
                });
            });
        </script>
    </body>
</html>
