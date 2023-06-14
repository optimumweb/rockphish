@props([
    'metaTitle' => null,
    'metaDescription' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($metaTitle) ? "{$metaTitle} | " : "" }}{{ config('app.name') }}</title>

        <meta name="description" content="{{ $metaDescription }}" />

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet" />

        @vite([
            'resources/sass/app.sass',
            'resources/js/app.js',
        ])

        <noscript>
            <style type="text/css">
                [data-aos] {
                    opacity: 1 !important;
                    transform: translate(0) scale(1) !important;
                }
            </style>
        </noscript>
    </head>
    <body>
        {{ $slot }}

        <script>
            addEventListener("DOMContentLoaded", () => {
                AOS.init();
            });
        </script>
    </body>
</html>
