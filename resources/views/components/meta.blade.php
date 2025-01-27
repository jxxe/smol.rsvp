<meta name="description" content="Free and easy RSVP pages, powered by Google Calendar">

<meta property="og:type" content="website">
<meta property="og:url" content="https://smol.rsvp">
<meta property="og:description" content="Free and easy RSVP pages, powered by Google Calendar">

<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://smol.rsvp">
<meta property="twitter:description" content="Free and easy RSVP pages, powered by Google Calendar">

@if(Route::current()->getName() === 'invitation')
    <meta property="twitter:image" content="https://v1.screenshot.11ty.dev/{{ urlencode(Request::url() . '?noAnimate=true') }}/opengraph/1:1/bigger">
    <meta property="og:image" content="https://v1.screenshot.11ty.dev/{{ urlencode(Request::url() . '?noAnimate=true') }}/opengraph/1:1/bigger">
@else
    <meta property="twitter:image" content="https://smol.rsvp/images/og-image.png">
    <meta property="og:image" content="https://smol.rsvp/images/og-image.png">
@endif

<script async src="https://beamanalytics.b-cdn.net/beam.min.js" data-token="dc450d08-0ea1-4a44-8ba3-ef4139b189a1"></script>