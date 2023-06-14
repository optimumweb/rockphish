@props([
    'metaTitle' => config('app.name'),
    'metaDescription' => null,
    'htmlClass' => null,
])

<!DOCTYPE html>
<html
    class="{{ $htmlClass }}"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $metaTitle }}</title>

        <meta name="description" content="{{ $metaDescription }}" />

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
