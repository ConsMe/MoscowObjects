<!DOCTYPE html><html lang=en><head><meta charset=utf-8><meta http-equiv=X-UA-Compatible content="IE=edge"><meta name=viewport content="width=device-width,initial-scale=1,height=device-height"><link rel=icon href=/img/favicon.png><meta name=csrf-token content="{{ csrf_token() }}"><script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=60a7dbf4-5bcd-4448-8bcc-65c2f095e874"></script><script>window.APP_NAME = "{{ env('APP_NAME') }}";
        window.ymapsState = {
          isReady: false,
        };
        ymaps.ready(function() {
            window.ymapsState.isReady = true;
        });
        window.isAuthorized = {{ $isAuthorized }};
        window.isAccepted = {{ $isAccepted }};
        @if (Auth::check())
            window.user = @json(Auth::user()->user_info);
        @endif
        @if (session('exceptionInfo'))
            window.infoMessages = @json(session('exceptionInfo'));
        @endif</script><title>{{ env('APP_NAME') }}</title><link href=/css/chunk-0fb7418a.03c5226c.css rel=prefetch><link href=/css/chunk-415ee53c.373f360c.css rel=prefetch><link href=/css/chunk-6dc787f8.20ec73eb.css rel=prefetch><link href=/css/chunk-753464aa.9f8392f6.css rel=prefetch><link href=/css/chunk-7d19c480.76d829e5.css rel=prefetch><link href=/css/chunk-7da43ca4.ce1ee1f8.css rel=prefetch><link href=/css/chunk-ae008d94.3f8075c2.css rel=prefetch><link href=/css/chunk-c393d520.f0fc3225.css rel=prefetch><link href=/css/chunk-c76aef02.efa7504c.css rel=prefetch><link href=/js/chunk-0fb7418a.7f6c1d23.js rel=prefetch><link href=/js/chunk-415ee53c.58ceeb56.js rel=prefetch><link href=/js/chunk-457db554.b6463cef.js rel=prefetch><link href=/js/chunk-6dc787f8.324b17b2.js rel=prefetch><link href=/js/chunk-753464aa.8b7579f2.js rel=prefetch><link href=/js/chunk-7d19c480.6e9bce1b.js rel=prefetch><link href=/js/chunk-7da43ca4.22cc8a2d.js rel=prefetch><link href=/js/chunk-ae008d94.b9edc6a8.js rel=prefetch><link href=/js/chunk-c393d520.7132bba0.js rel=prefetch><link href=/js/chunk-c76aef02.bda15bd3.js rel=prefetch><link href=/css/app.eb997353.css rel=preload as=style><link href=/js/app.dcc8fb3f.js rel=preload as=script><link href=/js/chunk-vendors.cf268758.js rel=preload as=script><link href=/css/app.eb997353.css rel=stylesheet></head><body><noscript><strong>We're sorry but {{ env('APP_NAME') }} doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript><div id=app></div><script src=/js/chunk-vendors.cf268758.js></script><script src=/js/app.dcc8fb3f.js></script></body></html>