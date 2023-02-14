<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="{{ asset('images/favicon.svg') }}">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=inter:400,700">

    @vite('resources/css/app.css')

    <title>Easy RSVP pages, powered by Google Calendar — smol.rsvp</title>
</head>

<body class="antialiased text-gray-700">
    <div class="p-4">
        <main class="max-w-screen-lg mx-auto space-y-14">
            <header>
                <div class="w-fit mx-auto">
                    <div class="w-fit font-bold flex gap-1 items-center select-none">
                        <span>smol</span> 
                        <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="h-6 text-blue-500">
                            <path d="M5.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H6a.75.75 0 01-.75-.75V12zM6 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H6zM7.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H8a.75.75 0 01-.75-.75V12zM8 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H8zM9.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V10zM10 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H10zM9.25 14a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V14zM12 9.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V10a.75.75 0 00-.75-.75H12zM11.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H12a.75.75 0 01-.75-.75V12zM12 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H12zM13.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H14a.75.75 0 01-.75-.75V10zM14 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H14z"></path>
                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd"></path>
                        </svg>
                        <span>rsvp</span>
                    </div>
                </div>
            </header>

            <h1 class="sm:text-3xl text-2xl font-bold text-center">Free and easy RSVP pages<br><span class="text-blue-500">powered by Google Calendar</span></h1>

            <a href="{{ route('auth.redirect') }}" class="px-3 flex items-center gap-2 w-fit mx-auto border rounded-lg py-2 shadow-sm bg-blue-500 text-white border-blue-500 ">
                <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="w-5">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path d="M3.064 7.51A9.996 9.996 0 0 1 12 2c2.695 0 4.959.99 6.69 2.605l-2.867 2.868C14.786 6.482 13.468 5.977 12 5.977c-2.605 0-4.81 1.76-5.595 4.123-.2.6-.314 1.24-.314 1.9 0 .66.114 1.3.314 1.9.786 2.364 2.99 4.123 5.595 4.123 1.345 0 2.49-.355 3.386-.955a4.6 4.6 0 0 0 1.996-3.018H12v-3.868h9.418c.118.654.182 1.336.182 2.045 0 3.046-1.09 5.61-2.982 7.35C16.964 21.105 14.7 22 12 22A9.996 9.996 0 0 1 2 12c0-1.614.386-3.14 1.064-4.49z"></path>
                </svg>

                <span>Login with Google Calendar</span>
            </a>

            <div class="text-center">
                <div>
                    <span class="text-blue-500">✓</span>
                    <span>Upload your own logo and image</span>
                </div>

                <div>
                    <span class="text-blue-500">✓</span>
                    <span>Limit to specific email domain</span>
                </div>

                <div>
                    <span class="text-blue-500">✓</span>
                    <span>Redirect to any URL after RSVP</span>
                </div>
            </div>

            <div class="px-4">
                <img class="hidden md:block rounded-lg shadow border" src="/images/demo.webp" alt="">
                <img class="md:hidden rounded-lg shadow border" src="/images/demo-mobile.webp" alt="">
            </div>

            <footer class="text-center pb-12">
                <p>A project by <a class="text-blue-500 underline" href="https://jero.zone">Jerome Paulos</a></p>
            </footer>
        </main>
    </div>
</body>

</html>
