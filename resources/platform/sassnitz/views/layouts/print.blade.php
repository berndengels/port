<!doctype html>
<html>
<head>
    <title>{{ __('Print Ansicht') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <style>
        @php
            echo file_get_contents(public_path('css/print.css'));
        @endphp
    </style>
</head>
<body>
    <main class="main">
        <div class="closer w-100 text-center">
            <button class="btn btn-sm btn-primary" onclick="window.close()">Schliessen</button>
        </div>
        @yield('main')
    </main>
</body>
</html>
