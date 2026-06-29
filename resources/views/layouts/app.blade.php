<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        {{ config('app.name', 'Laravel') }}
        @hasSection('title')
            | @yield('title')
        @endif
    </title>

    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    @yield('content')
</body>
</html>
