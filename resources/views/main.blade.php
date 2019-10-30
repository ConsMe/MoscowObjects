<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="format-detection" content="telephone=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ env('APP_NAME') }}</title>
  <link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
    crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
      rel="stylesheet"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
      crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto" />
  <link rel="icon" href="/img/favicon.png">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  <style>
    html {
      font-size: 16px;
    }
    .block1::before, .block2::before, .block3::before, .clickable:hover::after {
      background-repeat: no-repeat;
      background-position: center center;
      background-size: cover;
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
    .block1::before {
      background-image: url('/img/moskva-s-vysoty-ptichego-poleta.jpg');
    }
    .block2::before {
      background-image: url('/img/s1200.jpg');
    }
    .block3::before {
      background-image: url('/img/022c0e63297843.5aabd3a73993f_2.jpg');
    }
    .block1, .block2, .block3 {
      background-color: rgba(0,0,0,0.72);
    }
    .icon {
      width: 3rem;
    }
    i[class^='flaticon']::before {
      font-size: 3rem;
      margin-left: 0;
    }
    i.flaticon-builder::before {
      font-size: 3.3rem;
    }
    .block4 p {
      font-size: 0.8rem;
    }
    .fake-nav * {
      font-size: 14px !important;
    }
    .fake-nav img {
      height: 16px !important;
    }
    .fake-nav button {
      padding-left: 16px !important;
      padding-right: 16px !important;
    }
    @media (max-width: 1699.98px){
      html {
        font-size: 14px;
      }
      .fake-nav * {
        font-size: 11.9px !important;
      }
      .fake-nav img {
        height: 13.6px !important;
      }
    }
    @media (max-width: 1399.98px){
      .fake-nav * {
        font-size: 11.2px !important;
      }
      .fake-nav img {
        height: 12.8px !important;
      }
    }
    @media (max-width: 991.98px){
      html {
        font-size: 10px;
      }
      .block1, .block2, .block3 {
        height: 290px;
      }
      .block4 > .row {
        margin-bottom: 2rem;
      }
      .block4 p {
        font-size: 1rem;
      }
      .block-shadow {
        box-shadow: 0px 10px 15px -1px rgba(0, 0, 0, 0.28);
      }
      .z-minus-1 {
        z-index: -1;
      }
      .col-dropdown {
        padding-right: .2rem !important;
      }
      .dropdown-toggle {
        padding-right: 0 !important;
        padding-left: 0 !important;
      }
    }
    @media (max-width: 575.98px){
      .block1, .block2, .block3 {
        height: 180px;
      }
      .block4 p {
        font-size: 1.1rem;
      }
    }
    @media (min-width: 992px){
      .h-lg-50 {
        height: 50%;
      }
      .content {
        flex: 1;
      }
      .block-shadow-right {
        box-shadow: 10px 0px 15px -1px rgba(0, 0, 0, 0.28);
      }
      .block-shadow-left {
        box-shadow: -10px 0px 15px -1px rgba(0, 0, 0, 0.28);
      }
      .block-shadow-down {
        box-shadow: 0px 10px 15px -1px rgba(0, 0, 0, 0.28);
      }
      .col-lg-4 {
        -ms-flex: 0 0 40%;
        flex: 0 0 40%;
        max-width: 40%;
      }
      .col-dropdown {
        margin-right: 23%;
      }
    }
    @media (min-width: 1160px) {
      .col-lg-3 {
        -ms-flex: 0 0 18%;
        flex: 0 0 18%;
        max-width: 18%;
      }
    }
    @media (max-width: 1279px) {
      .fake-nav * {
        font-size: 9.8px !important;
      }
      .fake-nav img {
        height: 11.21px !important;
      }
    }
    @media (max-width: 1160px) {
      .icon {
        width: 2rem;
      }
      i[class^='flaticon']::before {
        font-size: 2rem;
      }
      i.flaticon-builder::before {
        font-size: 2.2rem;
      }
    }
    @media (max-width: 991.98px) {
      .icon {
        width: 3rem;
      }
      i[class^='flaticon']::before {
        font-size: 3rem;
      }
      i.flaticon-builder::before {
        font-size: 3.3rem;
      }
      .real-nav img {
        height: 1.12rem !important;
      }
      .real-nav * {
        font-size: 0.98rem;
      }
    }
    nav {
      box-shadow: 0px 10px 15px -1px rgba(0, 0, 0, 0.28);
      z-index: 1;
      font-size: .875rem;
    }
    .dropdown-menu {
      background-color: #282828;
      font-size: .875rem;
      left: 50%!important;
      -webkit-transform: translateX(-50%);
      transform: translateX(-50%);
      min-width: 100%;
    }
    .dropdown-item {
      color: white;
    }
    .dropdown-item:hover {
      background-color: #2a9fd6;
      color: white;
    }
    .navbar-brand {
      padding-top: 0.15rem !important;
    }
    .dropdown-toggle {
      color: #ffffff80;
    }
    .dropdown-toggle:hover {
      color: white;
    }
    .clickable {
      cursor: pointer;
    }
    .clickable:hover {
      background-color: rgba(0, 0, 0, .2) !important;
    }
    .custom-padding {
      padding-left: .25rem;
    }
    @font-face {
      font-family: "Flaticon";
      src: url("/fonts/Flaticon.eot");
      src: url("/fonts/Flaticon.eot?#iefix") format("embedded-opentype"),
      url("/fonts/Flaticon.woff2") format("woff2"),
      url("/fonts/Flaticon.woff") format("woff"),
      url("/fonts/Flaticon.ttf") format("truetype"),
      url("/fonts/Flaticon.svg#Flaticon") format("svg");
      font-weight: normal;
      font-style: normal;
    }

    @media screen and (-webkit-min-device-pixel-ratio:0) {
      @font-face {
        font-family: "Flaticon";
        src: url("/fonts/Flaticon.svg#Flaticon") format("svg");
      }
    }

    [class^="flaticon-"]:before, [class*=" flaticon-"]:before,
    [class^="flaticon-"]:after, [class*=" flaticon-"]:after {
      font-family: Flaticon;
      font-size: 20px;
      font-style: normal;
      margin-left: 20px;
    }

    .flaticon-builder:before { content: "\f100"; }
    .flaticon-file:before { content: "\f101"; }
    .flaticon-locked-padlock:before { content: "\f102"; }
    .flaticon-wrench:before { content: "\f103"; }
    .flaticon-information-button:before { content: "\f104"; }

    .fake-nav {
      position: absolute;
      left: 0;
      width: 100%;
      visibility: hidden;
    }
    #realLogo {
      -webkit-transition: opacity 1s ease-out 0.5s;
      -moz-transition: opacity 1s ease-out 0.5s;
      -o-transition: opacity 1s ease-out 0.5s;
      transition: opacity 0.3s ease-out;
    }
  </style>
</head>

<body>

  <body
    style="min-height: 100%;position: absolute;left: 0;top: 0;width: 100%;overflow-x: hidden;font-family: Roboto, sans-serif;">
    <section class="d-flex flex-column" style="min-height: 100vh;overflow: hidden;">
      <nav class="navbar navbar-dark navbar-expand-md real-nav" style="background-color: #060606;">
        <div class="col-6 col-sm-1 pl-0">
          <a href="/" class="navbar-brand">
            <img src="/img/title.png" style="height: 1rem; opacity: 0;" id="realLogo" />
          </a>
        </div>
        <div class="col text-right">
          <div class="dropdown nav-item col-dropdown d-inline-block">
            <a data-toggle="dropdown" aria-expanded="false" href="#" class="dropdown-toggle nav-link">
              Кабинет <i class="fa fa-user ml-2" style="{{ auth()->check() ? 'color: #2A9FD6;' : '' }}"></i>
            </a>
            <div role="menu" class="dropdown-menu">
              @guest
                <a role="presentation" href="/lk/login" class="dropdown-item">Войти</a>
              @endguest
              @auth
                <a role="presentation" href="/lk/account" class="dropdown-item">Аккаунт</a>
                <a role="presentation" href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              @endauth
            </div>
          </div>
        </div>
      </nav>
      <nav class="navbar navbar-expand navbar-dark bg-dark pl-0 pr-0 shadow pb-1 pb-lg-2 fake-nav">
        <div class="row w-100 m-0">
          <div class="col">
            <ul class="navbar-nav row text-center">
              <li class="nav-item col-5 col-lg pl-lg-0 pr-lg-0 text-left text-lg-center"><a href="/"
                  class="navbar-brand mr-0"><img src="/img/title.png" style="height: 1rem;" id="fakeLogo"></a></li>
              <li
                class="nav-item col-6 col-lg dropdown text-uppercase pl-lg-0 pr-0 order-3 order-lg-1 border-sm-bottom">
                <a href="/" id="categoryDropdown" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false"
                  class="nav-link dropdown-toggle text-truncate text-left text-lg-center pl-xs-0">Земельные
                  участки</a>
                <div aria-labelledby="categoryDropdown"
                  class="dropdown-menu my-dropdown-menu-center category p-0"><a href="/"
                    class="dropdown-item">Крупные Инвест.объекты</a><a href="/"
                    class="dropdown-item">Коммерческие помещения</a></div>
              </li>
              <li data-v-11d3cc11=""
                class="nav-item col-6 col-lg-auto dropdown order-5 order-lg-2 padding-20 pr-xs-3">
                <form data-v-11d3cc11=""><input data-v-11d3cc11="" type="text" placeholder="Лот или адрес"
                    class="form-control bg-transparent border-white"></form>
                <div data-v-11d3cc11="" class="dropdown-menu dropdown-search" style="opacity: 1;"><span
                    data-v-11d3cc11="" class="dropdown-item notfound">
                    Ничего не найдено
                  </span></div>
              </li>
              <li class="nav-item col-6 col-lg-auto order-4 order-lg-3 border-sm-top">
                <div role="group" class="btn-group"><button type="button"
                    class="btn btn-outline-dark rounded-0 active">Карта</button><button type="button"
                    class="btn btn-outline-dark rounded-0">Список</button></div>
              </li>
              <li class="nav-item col-4 col-lg-auto order-1 order-lg-4 pr-xs-0"><a href="/"
                  class="nav-link"><i class="fa fa-heart mr-1 position-relative"></i>
                  Избранное
                </a></li>
              <li class="nav-item col-3 col-lg-auto dropdown order-2 order-lg-5 px-xs-0"><a href="/"
                  id="lkDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false" class="nav-link dropdown-toggle">
                  Кабинет
                  <i class="fa fa-user ml-2 text-primary"></i></a>
                <div aria-labelledby="lkDropdown" class="dropdown-menu w-auto lk-menu"><a
                    href="/lk/objects/new" class="dropdown-item">
                    Новый объект
                  </a><a href="/lk/objects" class="dropdown-item">
                    Каталог
                  </a><a href="/lk/users" class="dropdown-item">
                    Пользователи
                  </a><a href="/lk/account" class="dropdown-item">
                    Аккаунт
                  </a><a href="" class="dropdown-item">Выйти</a>
                  <form action="/logout" method="POST" style="display: none;"><input type="hidden"
                      name="_token"></form>
                </div>
              </li>
              <li class="nav-item col-6 col-lg text-uppercase pl-0 pr-0 order-5 order-lg-6 padding-20"><a
                  href="/" class="nav-link dropdown-toggle"><span
                    class="d-inline-block position-relative">
                    Фильтр
                    <!----></span></a></li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="row no-gutters text-white ml-0 mr-0 content">
        <div
          class="col-12 d-flex flex-column justify-content-center align-items-center col-lg-4 block1 pt-4 pb-3 pl-2 pr-2 block-shadow block-shadow-right clickable"
          onclick="location.href='/zu'">
          <h5 class="text-center text-white" style="position: relative;"><span
              class="d-block">ЗЕМЕЛЬНЫЕ УЧАСТКИ</span><span class="d-block">ДЛЯ НОВОГО
              СТРОИТЕЛЬСТВА</span><span class="d-block">И ОБЪЕКТЫ КАПИТАЛЬНОГО
              СТРОИТЕЛЬСТВА</span><span class="d-block">ПОД РЕКОНСТРУКЦИЮ</span></h5>
          <p
            class="text-uppercase position-relative text-white h2 pb-2 pb-lg-4 border-bottom mt-4 pl-4 pr-4 font-weight-bold mb-0 mb-lg-2">
            {{ $zuCount }} Предложений</p>
          <p class="position-relative text-white h2 mt-2 mt-lg-4 font-weight-bold">{{ $zuGroundS }} Га</p>
        </div>
        <div class="col-12 col-lg-4 pl-0 pr-0">
          <div class="row h-100 ml-0 mr-0">
            <div
              class="col-12 d-flex flex-column justify-content-center align-items-center block2 pt-4 pb-3 pl-2 pr-2 block-shadow block-shadow-down clickable h-lg-50"
              onclick="location.href='/invest'">
              <h5 class="text-center text-white" style="z-index: 2;position: relative;">
                <span class="d-block">ТОРГОВЫЕ, ОФИСНЫЕ,</span><span
                  class="d-block">МНОГОФУНКЦИОНАЛЬНЫЕ ЦЕНТРЫ,</span><span
                  class="d-block">ГОСТИНИЦЫ</span><span class="d-block">ИНВЕСТИЦИОННЫЕ
                  ПОРТФЕЛИ НЕДВИЖИМОСТИ</span></h5>
              <p
                class="text-uppercase position-relative text-white h2 pb-2 pb-lg-4 border-bottom mt-4 pl-4 pr-4 font-weight-bold mb-0 mb-lg-2">
                <strong>{{ $investCount }} ПРЕДЛОЖЕНИЙ</strong></p>
              <p class="position-relative text-white h2 mt-2 mt-lg-4 font-weight-bold"><strong>{{ $investAreaS }} м<sup>2<sup></strong></p>
            </div>
            <div
              class="col-12 d-flex flex-column justify-content-center align-items-center block3 pt-4 pb-3 pl-2 pr-2 block-shadow clickable h-lg-50"
              onclick="location.href='/retail'">
              <h5 class="text-center text-white" style="z-index: 2;position: relative;">
                <span class="d-block">ТОРГОВЫЕ ПОМЕЩЕНИЯ, STREET-RETAIL,</span><span
                  class="d-block">ГОТОВЫЙ АРЕНДНЫЙ БИЗНЕС</span></h5>
              <p
                class="text-uppercase position-relative text-white h2 pb-2 pb-lg-4 border-bottom mt-4 pl-4 pr-4 font-weight-bold mb-0 mb-lg-2">
                <strong>{{ $retailCount }} ПРЕДЛОЖЕНИЙ</strong><br /></p>
              <p class="position-relative text-white h2 mt-2 mt-lg-4 font-weight-bold"><strong>{{ $retailAreaS }} м<sup>2<sup></strong><br /></p>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg d-flex flex-column p-4 pl-0 pr-0 block4 z-minus-1 block-shadow-left text-justify"
          style="background-color: #30415a;justify-content: space-between;">
          <div class="row justify-content-center">
            <div class="col">
              <p>Проект ИНВЕСТТЕХ.PRO является профессиональным инструментом поиска объектов недвижимости для целей девелопмента и крупных инвестиций.<br /></p>
            </div>
            <div class="col-auto custom-padding"><i class="flaticon-wrench"></i></div>
          </div>
          <div class="row">
            <div class="col">
              <p>Представленный каталог объектов предназначен, в первую очередь, для пользования представителями компаний-застройщиков, частных и институциональных инвесторов, а также брокеров по недвижимости.<br /></p>
            </div>
            <div class="col-auto custom-padding"><i class="flaticon-builder"></i></div>
          </div>
          <div class="row">
            <div class="col">
              <p>Доступ к полному функционалу и каталогу проекта возможен только после идентификации нового пользователя и авторизации.<br /></p>
            </div>
            <div class="col-auto custom-padding"><i class="flaticon-locked-padlock"></i></div>
          </div>
          <div class="row">
            <div class="col">
              <p>Настоящий сайт и любые размещенные на нем сведения носят информационный характер и не являются публичной офертой.<br /></p>
            </div>
            <div class="col-auto custom-padding"><i class="flaticon-information-button"></i>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Проект разработан в ГК «Инвестиционные технологии». Использование материалов сайта разрешается только с согласия правообладателя.<br /></p>
            </div>
            <div class="col-auto custom-padding"><i class="flaticon-file"></i></div>
          </div>
        </div>
      </div>
    </section>
  </body>
  <script>
    $(document).ready(function() {
      if (window.outerWidth < 980) {
        $('#realLogo').css('margin-left', '5px').css('opacity', 1);
      } else {
        var left = $('#fakeLogo')[0].offsetLeft;
        var pl;
        if (window.outerWidth >= 1280) {
          pl = 16;
        } else {
          pl = 14;
        }
        $('#realLogo').css('margin-left', (left - pl) + 'px').css('opacity', 1);
      }
    })
  </script>
</body>

</html>
