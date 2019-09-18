<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="/img/favicon.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=60a7dbf4-5bcd-4448-8bcc-65c2f095e874" type="text/javascript"></script>
    <script>
        window.APP_NAME = "{{ env('APP_NAME') }}";
        window.ymapsState = {
          isReady: false,
        };
        ymaps.ready(() => window.ymapsState.isReady = true);
        window.isAuthorized = {{ $isAuthorized }};
        window.isAccepted = {{ $isAccepted }};
        @if (Auth::check())
            window.user = @json(Auth::user()->user_info);
        @endif
        @if (session('exceptionInfo'))
            window.infoMessages = @json(session('exceptionInfo'));
        @endif
    </script>
    <title>{{ env('APP_NAME') }}</title>
  <link href="/0.js" rel="prefetch"><link href="/1.js" rel="prefetch"><link href="/2.js" rel="prefetch"><link href="/3.js" rel="prefetch"><link href="/4.js" rel="prefetch"><link href="/5.js" rel="prefetch"><link href="/6.js" rel="prefetch"><link href="/7.js" rel="prefetch"><link href="/8.js" rel="prefetch"><link href="/9.js" rel="prefetch"><link href="/about.js" rel="prefetch"><link href="/app.js" rel="preload" as="script"></head>
  <body>
    <noscript>
      <strong>We're sorry but {{ env('APP_NAME') }} doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>
    <div id="app"></div>
    <!-- built files will be auto injected -->
  <script type="text/javascript" src="/app.js"></script></body>
</html>
