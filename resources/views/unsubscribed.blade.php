<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
      html {
        font-size: 12px;
      }
      .block4 p {
        font-size: 1.1rem;
      }
    }
    @media (min-width: 992px){
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
      background-color: rgba(0, 0, 0, .5) !important;
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
          <a href="/" class="navbar-brand">
            <img src="/img/title.png" style="height: 1rem;" />
          </a>
        </div>
      </nav>
      <div class="row mt-5">
        <div class="col offset-2">
          <p class="mt-5">
            Email {{ $email }} успешно удален из базы рассылки
          </p>
          @auth
            <p>
              <a href="/lk/account">Перейти в личный кабинет</a>
            </p>
          @endauth
        </div>
      </div>
    </section>
  </body>
</body>

</html>
