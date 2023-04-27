<x-layout title="Free and easy RSVP pages, powered by Google Calendar">
    <div class="space-y-14">
        <h1 class="sm:text-3xl text-2xl font-bold text-center">Free and easy RSVP pages<br><span class="text-blue-500">powered by Google Calendar</span></h1>
    
        <div class="text-center space-y-2">
            {{-- <a href="{{ route('auth.redirect') }}" class="px-3 flex items-center gap-2 w-fit mx-auto border rounded-lg py-2 shadow-sm bg-blue-500 text-white border-blue-500 ">
                <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="w-5">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path d="M3.064 7.51A9.996 9.996 0 0 1 12 2c2.695 0 4.959.99 6.69 2.605l-2.867 2.868C14.786 6.482 13.468 5.977 12 5.977c-2.605 0-4.81 1.76-5.595 4.123-.2.6-.314 1.24-.314 1.9 0 .66.114 1.3.314 1.9.786 2.364 2.99 4.123 5.595 4.123 1.345 0 2.49-.355 3.386-.955a4.6 4.6 0 0 0 1.996-3.018H12v-3.868h9.418c.118.654.182 1.336.182 2.045 0 3.046-1.09 5.61-2.982 7.35C16.964 21.105 14.7 22 12 22A9.996 9.996 0 0 1 2 12c0-1.614.386-3.14 1.064-4.49z"></path>
                </svg>
    
                <span>Login with Google Calendar</span>
            </a> --}}
    
            <div class="px-3 flex items-center gap-2 w-fit mx-auto border rounded-lg py-2 shadow-sm bg-gray-500 text-white border-gray-500 cursor-not-allowed select-none">
                <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="w-5">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path d="M3.064 7.51A9.996 9.996 0 0 1 12 2c2.695 0 4.959.99 6.69 2.605l-2.867 2.868C14.786 6.482 13.468 5.977 12 5.977c-2.605 0-4.81 1.76-5.595 4.123-.2.6-.314 1.24-.314 1.9 0 .66.114 1.3.314 1.9.786 2.364 2.99 4.123 5.595 4.123 1.345 0 2.49-.355 3.386-.955a4.6 4.6 0 0 0 1.996-3.018H12v-3.868h9.418c.118.654.182 1.336.182 2.045 0 3.046-1.09 5.61-2.982 7.35C16.964 21.105 14.7 22 12 22A9.996 9.996 0 0 1 2 12c0-1.614.386-3.14 1.064-4.49z"></path>
                </svg>
    
                <span>Login with Google Calendar</span>
            </div>
    
            <p class="text-sm text-gray-500">Coming soon, pending review from Google</p>
        </div>
    
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
    
        <div class="px-4 w-fit mx-auto">
            <img class="animate-hover w-96 rounded-lg shadow z-20 relative border" src="/images/example1.png" alt="">
            <img class="animate-hover2 w-96 ml-72 -mt-24 rounded-lg z-10 relative shadow border" src="/images/example2.png" alt="">
            <img class="animate-hover3 w-96 ml-24 -mt-24 rounded-lg relative shadow border" src="/images/example3.png" alt="">
        </div>
    </div>
</x-layout>