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
        @endif</script><title>{{ env('APP_NAME') }}</title><link href=/css/chunk-0fb7418a.03c5226c.css rel=prefetch><link href=/css/chunk-350c199d.d43fb5f2.css rel=prefetch><link href=/css/chunk-6dc787f8.20ec73eb.css rel=prefetch><link href=/css/chunk-753464aa.9f8392f6.css rel=prefetch><link href=/css/chunk-7d19c480.76d829e5.css rel=prefetch><link href=/css/chunk-7da43ca4.ce1ee1f8.css rel=prefetch><link href=/css/chunk-ae008d94.3f8075c2.css rel=prefetch><link href=/css/chunk-c393d520.f0fc3225.css rel=prefetch><link href=/css/chunk-c76aef02.efa7504c.css rel=prefetch><link href=/js/chunk-0fb7418a.3caff668.js rel=prefetch><link href=/js/chunk-350c199d.531c4458.js rel=prefetch><link href=/js/chunk-457db554.b6463cef.js rel=prefetch><link href=/js/chunk-6dc787f8.416fc7ba.js rel=prefetch><link href=/js/chunk-753464aa.3260e279.js rel=prefetch><link href=/js/chunk-7d19c480.567d42b0.js rel=prefetch><link href=/js/chunk-7da43ca4.07c20f64.js rel=prefetch><link href=/js/chunk-ae008d94.68512468.js rel=prefetch><link href=/js/chunk-c393d520.cbc13633.js rel=prefetch><link href=/js/chunk-c76aef02.3bc071c4.js rel=prefetch><link href=/css/app.9671d502.css rel=preload as=style><link href=/js/app.81f05e9b.js rel=preload as=script><link href=/js/chunk-vendors.cf268758.js rel=preload as=script><link href=/css/app.9671d502.css rel=stylesheet></head><body><noscript><strong>We're sorry but {{ env('APP_NAME') }} doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript><div id=app></div><script src=/js/chunk-vendors.cf268758.js></script><script src=/js/app.81f05e9b.js></script></body></html>