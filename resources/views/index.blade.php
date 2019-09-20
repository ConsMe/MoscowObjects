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
        @endif</script><title>{{ env('APP_NAME') }}</title><link href=/css/chunk-0fb7418a.03c5226c.css rel=prefetch><link href=/css/chunk-1586f5ff.95086b53.css rel=prefetch><link href=/css/chunk-753464aa.9f8392f6.css rel=prefetch><link href=/css/chunk-7da43ca4.ff1fd1ab.css rel=prefetch><link href=/css/chunk-a3b88876.e1bb9756.css rel=prefetch><link href=/css/chunk-ae008d94.3f8075c2.css rel=prefetch><link href=/css/chunk-c393d520.8af679a4.css rel=prefetch><link href=/css/chunk-c76aef02.efa7504c.css rel=prefetch><link href=/js/about.8bd074be.js rel=prefetch><link href=/js/chunk-0fb7418a.7c8e4653.js rel=prefetch><link href=/js/chunk-1586f5ff.6dbf6311.js rel=prefetch><link href=/js/chunk-457db554.b6463cef.js rel=prefetch><link href=/js/chunk-753464aa.3260e279.js rel=prefetch><link href=/js/chunk-7da43ca4.01cf8e57.js rel=prefetch><link href=/js/chunk-a3b88876.6abacd62.js rel=prefetch><link href=/js/chunk-ae008d94.106ac1cd.js rel=prefetch><link href=/js/chunk-c393d520.557046bc.js rel=prefetch><link href=/js/chunk-c76aef02.b3a7cf96.js rel=prefetch><link href=/css/app.cec62780.css rel=preload as=style><link href=/js/app.36743669.js rel=preload as=script><link href=/js/chunk-vendors.56d594b5.js rel=preload as=script><link href=/css/app.cec62780.css rel=stylesheet></head><body><noscript><strong>We're sorry but {{ env('APP_NAME') }} doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript><div id=app></div><script src=/js/chunk-vendors.56d594b5.js></script><script src=/js/app.36743669.js></script></body></html>