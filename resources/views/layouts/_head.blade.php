<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
{{-- Evita o "flash" branco antes do CSS carregar quando o sistema está no modo escuro --}}
<meta name="color-scheme" content="light dark">

<title>@yield('title', config('app.name', 'TaskFlow'))</title>

<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

@vite(['resources/css/app.css', 'resources/js/app.js'])
