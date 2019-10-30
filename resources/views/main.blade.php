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
    .block4 p {
      font-size: 0.8rem;
    }
    @media (max-width: 1699.98px){
      html {
        font-size: 14px;
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
      .icon {
        width: 3rem;
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
    @media (max-width: 1160px) {
      .icon {
        width: 2rem;
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
  </style>
</head>

<body>

  <body
    style="min-height: 100%;position: absolute;left: 0;top: 0;width: 100%;overflow-x: hidden;font-family: Roboto, sans-serif;">
    <section class="d-flex flex-column" style="min-height: 100vh;overflow: hidden;">
      <nav class="navbar navbar-dark navbar-expand-md" style="background-color: #060606;">
        <div class="col-6 col-sm-1 offset-lg-1">
          <a href="#" class="navbar-brand">
            <img src="/img/title.png" style="height: 1rem;" />
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
            <div class="col-auto custom-padding"><img src="/img/002-wrench.png" class="icon" /></div>
          </div>
          <div class="row">
            <div class="col">
              <p>Представленный каталог объектов предназначен, в первую очередь, для пользования представителями компаний-застройщиков, частных и институциональных инвесторов, а также брокеров по недвижимости.<br /></p>
            </div>
            <div class="col-auto custom-padding"><img src="/img/003-builder.png" class="icon" /></div>
          </div>
          <div class="row">
            <div class="col">
              <p>Доступ к полному функционалу и каталогу проекта возможен только после идентификации нового пользователя и авторизации.<br /></p>
            </div>
            <div class="col-auto custom-padding"><img src="/img/001-lock.png" class="icon" /></div>
          </div>
          <div class="row">
            <div class="col">
              <p>Настоящий сайт и любые размещенные на нем сведения носят информационный характер и не являются публичной офертой.<br /></p>
            </div>
            <div class="col-auto custom-padding"><img src="/img/005-information-button.png" class="icon" />
            </div>
          </div>
          <div class="row">
            <div class="col">
              <p>Проект разработан в ГК «Инвестиционные технологии». Использование материалов сайта разрешается только с согласия правообладателя.<br /></p>
            </div>
            <div class="col-auto custom-padding"><img src="/img/004-document.png" class="icon" /></div>
          </div>
        </div>
      </div>
    </section>
  </body>
</body>

</html>
