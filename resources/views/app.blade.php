<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    
    <link rel="icon" href="{{ asset('images/favicon.svg') }}">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=inter:400,700">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body class="antialiased text-gray-700">
    <div class="contents">
        @inertia
    </div>
</body>

</html>