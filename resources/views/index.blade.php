<!DOCTYPE html><html lang=en><head><meta charset=utf-8><meta http-equiv=X-UA-Compatible content="IE=edge"><meta name=viewport content="width=device-width,initial-scale=1"><link rel=icon href=/img/favicon.ico><meta name=csrf-token content="{{ csrf_token() }}"><script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=60a7dbf4-5bcd-4448-8bcc-65c2f095e874"></script><script>window.ymapsState = {
          isReady: false,
        };
        ymaps.ready(() => window.ymapsState.isReady = true);
        window.isAuthorized = {{ $isAuthorized }};
        window.isAccepted = {{ $isAccepted }};
        @if (Auth::check())
            window.user = @json(Auth::user()->user_info);
        @endif</script><title>yandex-map</title><link href=/css/chunk-0fb7418a.03c5226c.css rel=prefetch><link href=/css/chunk-18beb0ee.83916c0f.css rel=prefetch><link href=/css/chunk-41c3a02b.e583347c.css rel=prefetch><link href=/css/chunk-5d479cda.a44ff2f6.css rel=prefetch><link href=/css/chunk-7da43ca4.8af679a4.css rel=prefetch><link href=/css/chunk-ae008d94.bfe34a54.css rel=prefetch><link href=/css/chunk-c393d520.8af679a4.css rel=prefetch><link href=/css/chunk-c76aef02.efa7504c.css rel=prefetch><link href=/js/about.a7af16c8.js rel=prefetch><link href=/js/chunk-0fb7418a.382d1c90.js rel=prefetch><link href=/js/chunk-18beb0ee.60c3cb7a.js rel=prefetch><link href=/js/chunk-41c3a02b.96207b2b.js rel=prefetch><link href=/js/chunk-457db554.b6463cef.js rel=prefetch><link href=/js/chunk-5d479cda.3a824af9.js rel=prefetch><link href=/js/chunk-7da43ca4.1bb49838.js rel=prefetch><link href=/js/chunk-ae008d94.d6e921ea.js rel=prefetch><link href=/js/chunk-c393d520.8c375ea6.js rel=prefetch><link href=/js/chunk-c76aef02.173820cc.js rel=prefetch><link href=/css/app.cbcf1c5b.css rel=preload as=style><link href=/js/app.b67f88cc.js rel=preload as=script><link href=/js/chunk-vendors.4cd44250.js rel=preload as=script><link href=/css/app.cbcf1c5b.css rel=stylesheet></head><body><noscript><strong>We're sorry but yandex-map doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript><div id=app></div><script src=/js/chunk-vendors.4cd44250.js></script><script src=/js/app.b67f88cc.js></script></body></html>