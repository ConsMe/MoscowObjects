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
        @endif</script><title>{{ env('APP_NAME') }}</title><link href=/css/chunk-0fb7418a.03c5226c.css rel=prefetch><link href=/css/chunk-213b2078.7ed24f37.css rel=prefetch><link href=/css/chunk-31416119.fc9c92ce.css rel=prefetch><link href=/css/chunk-3447cbc5.9c4ecb21.css rel=prefetch><link href=/css/chunk-6337b0d7.efa7504c.css rel=prefetch><link href=/css/chunk-6d2b98f5.4cfd7105.css rel=prefetch><link href=/css/chunk-6dc787f8.20ec73eb.css rel=prefetch><link href=/css/chunk-85e312ca.25a291aa.css rel=prefetch><link href=/css/chunk-a3f31c6a.f2279aee.css rel=prefetch><link href=/css/chunk-d9fb3616.cb7a6570.css rel=prefetch><link href=/js/chunk-0fb7418a.7f6c1d23.js rel=prefetch><link href=/js/chunk-213b2078.6e2718b3.js rel=prefetch><link href=/js/chunk-31416119.4805113f.js rel=prefetch><link href=/js/chunk-3447cbc5.e4f7f944.js rel=prefetch><link href=/js/chunk-6337b0d7.0b9a86a3.js rel=prefetch><link href=/js/chunk-6d2b98f5.50c71dfc.js rel=prefetch><link href=/js/chunk-6dc787f8.324b17b2.js rel=prefetch><link href=/js/chunk-85e312ca.e9ea42c8.js rel=prefetch><link href=/js/chunk-a3f31c6a.691b36a5.js rel=prefetch><link href=/js/chunk-d9fb3616.153971a7.js rel=prefetch><link href=/css/app.ea7dec91.css rel=preload as=style><link href=/js/app.60b9214b.js rel=preload as=script><link href=/js/chunk-vendors.78959941.js rel=preload as=script><link href=/css/app.ea7dec91.css rel=stylesheet></head><body><noscript><strong>We're sorry but {{ env('APP_NAME') }} doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript><div id=app></div><script src=/js/chunk-vendors.78959941.js></script><script src=/js/app.60b9214b.js></script></body></html>