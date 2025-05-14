<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- لو تستخدم Vite --}}
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>
