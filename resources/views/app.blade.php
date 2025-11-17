<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @php
        $logo_url = \App\Models\Setting::getSettings()->logo_url;
    @endphp
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ALORÉA</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="icon" type="image/x-icon" href="{{ $logo_url }}">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    </head>
    <body class="font-sans antialiased">
        <div id="root"></div>
        @viteReactRefresh
        @vite(['resources/js/main.jsx','resources/css/app.css'])
    </body>
</html>
