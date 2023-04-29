<!DOCTYPE html>
<html class="text-[15px]" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="{{ asset('images/favicon.svg') }}">

    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=figtree:400,400i,600,600i&display=swap">

    @vite('resources/css/app.css')

    <title>{{ $title }} — smol.rsvp</title>
    <x-meta/>
</head>

<body class="antialiased text-gray-700 overflow-x-hidden">
    <div class="p-4">
        <main class="max-w-screen-lg mx-auto space-y-14">
            <header>
                <div class="w-fit mx-auto">
                    <a href="/">
                        <x-logo/>
                    </a>
                </div>
            </header>

            <div>
                {{ $slot }}
            </div>

            <footer class="text-center pb-12 space-y-2">
                <p>
                    <span>A project by</span>
                    <a class="text-blue-500 underline" href="https://twitter.com/intent/follow?screen_name=jeromepaulos">Jerome Paulos</a>
                    <span class="mx-2">•</span>
                    <a class="text-blue-500 underline" href="{{ route('privacy') }}">Privacy Policy</a>
                </p>
            </footer>
        </main>
    </div>
</body>

</html>