<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <style>
        @page {
            margin: 20px;
        }
        html {
            font-size: 12px;
        }
        @font-face {
            font-family: "Roboto";
            src: url("{{ public_path('pdf/fonts/Roboto-Regular.ttf') }}") format("truetype");
            font-style: normal;
            font-weight: normal;
        }
        @font-face {
            font-family: "Roboto";
            src: url("{{ public_path('pdf/fonts/Roboto-Bold.ttf') }}") format("truetype");
            font-style: normal;
            font-weight: bold;
        }
        body {
            font-family: Roboto;
            position: relative;
            color: #6d6c6c;
            /* border: 1px solid #8ac3fb; */
            padding: 10px;
        }
        table {
            border-collapse: collapse;
        }
        td {
            vertical-align: top;
        }
        td, p, div {
            font-family: Roboto;
        }
        .info p {
            margin: 5px;
        }
        hr {
            border: none;
            background-color: #b3b3b3;
            height: 1px;
            margin-top: 10px;
        }
        .caption {
            position: absolute;
            right: 1px;
            top: 1px;
            display: inline-block;
            color: white;
            padding: 3px 10px 8px 10px;
        }
        .map-icon {
            display: inline-block;
            min-width: 5.6rem;
            position: absolute;
            top: 50%;
            left: 50%;
            background-color: rgb(33, 6, 68);
            margin-left: 1.8rem;
            border: 1px solid white;
            @if ($object['type'] === 'ZU' && isset($object['areaS']))
                @unless ($hide_company_info_in_tizer)
                    margin-top: -8.48rem;
                @else
                    margin-top: -6.0rem;
                @endif
            @else
                @unless ($hide_company_info_in_tizer)
                    margin-top: -7rem;
                @else
                    margin-top: -4.5rem;
                @endif
            @endif
        }
        .row {
            color: white;
            white-space: nowrap;
            margin: 0;
            box-sizing: border-box;
            padding: 0 0.5rem;
            font-size: 92%;
            position: relative;
            display: block;
        }
        .row-table {
            color: white;
            border: none;
            font-size: 1rem;
            position: relative;
            display: table;
            padding: 0;
        }
        .row-table td {
            padding: .05rem 0.7rem;
        }
        .row > div {
            padding: .05rem 0.4rem;
        }
        .row:after, .row:before {
            @if ($object['type'] === 'ZU' && isset($object['areaS']))
                top: 3.27rem;
            @else
                top: 1.845rem;
            @endif
            left: 0;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            display: inline-block;
        }

        .row:after {
            border-color: rgba(136, 183, 213, 0);
            border-width: 1.7rem .4rem 0 0;
            @if ($object['type'] === 'ZU')
                border-top-color: rgb(33, 6, 68);
            @else
                border-top-color: #c00;
            @endif
            z-index: 2;
        }
        .row:before {
            border-color: rgba(194, 225, 245, 0);
            border-top-color: white;
            border-width: 1.8rem .55rem 0 0;
            margin-left: -.08rem;
            z-index: 1;
            @if ($object['type'] === 'ZU' && isset($object['areaS']))
                top: 3.28rem;
            @endif
        }
        footer {
            position: fixed;
            left: 20px;
            bottom: 0px;
            height: 70px;
            right: 20px;
            background-color: transparent;
            padding-top: 10px;
            border-top: 1px solid #2c3e50;
        }
        footer div {
            position: relative;
            top: 0;
            display: inline-block;
            width: 50%;
        }
        footer div img {
            position: relative;
            height: 60px;
            top: 0;
            margin-left: -5px;
            margin-top: 15px;
        }
        footer div p {
            text-align: right;
            padding: 0;
            margin-top: 0;
            margin-bottom: 0;
            margin-right: 5px;
            font-weight: bold;
            color: #2c3e50;
        }
        footer a {
            color: #bc2a37;
            text-decoration: none;
        }
    </style>
</head>
<body>
    @unless ($hide_company_info_in_tizer)
      <footer>
          <div>
              <img src="{{ storage_path('app/logos/Investtex_viz_final_small.jpg') }}">
          </div>
          <div style="padding-bottom: 5px;">
              <p>Москва, Россия</p>
              <p>129626, проспект Мира, 102к2</p>
              <p>
                  <a href="http://investtex.ru" target="_blank">investtex.ru</a>
                  <a href="http://investtex.pro" target="_blank" style="margin-left: 10px;">investtex.pro</a>
              </p>
          </div>
      </footer>
    @endif
    <div style="padding: 10px; position: absolute; top: 0; right: 30px; width: 30%;">
        <img
          src="data:image/png;base64, {{ $b64_img }}"
          style="width: 350px;">
        <div class="map-icon">
            @if ($object['type'] === 'ZU')
              @if (isset($object['areaS']))
                <table class="row row-table">
                    <tr>
                        <td style="text-align: center;">
                            <p style="{{ isset($object['areaS']) ? 'border-bottom: 1px solid gray;' : '' }}margin: 0; padding: 0;">
                                {{ $object['groundS'] }}
                            </p>
                        </td>
                    </tr>
                    @if (isset($object['areaS']))
                      <tr>
                          <td style="text-align: center; font-size: 0.83rem; padding-bottom: 0.2rem;">
                              {{ str_replace('м<sup>2</sup>', '', $object['areaS']) }} м<sup>2</sup>
                          </td>
                      </tr>
                    @endif
                </table>
              @else
                <div class="row">
                  <div style="padding-bottom: 0.3rem; font-size: 0.8rem;">
                    {{ $object['groundS'] }}
                  </div>
                </div>
              @endif
            @elseif ($object['type'] === 'Invest')
                <div class="row" style="background-color: #c00;">
                    <div style="padding-bottom: 0.3rem; text-transform: uppercase;font-size: 0.8rem;">{{ $object['buildingName'] }}</div>
                </div>
            @endif
        </div>
    </div>
    <div style="width: 65%;position: relative; padding: 10px 10px {{ $hide_company_info_in_tizer ? '15px' : '50px' }} 10px;">
        <table style="border: 0px solid black; width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 330px; position: relative;">
                        <img
                          src="{{ storage_path(env('BIG_IMAGES_PATH')).$object['images'][0]['filename'] }}"
                          style="width: 330px;">
                        @if ($object['type'] === 'Invest' || strlen($object['images'][0]['caption']))
                            <span
                            class="caption"
                            style="background-color: {{ $object['type'] === 'Invest' ? '#c00; text-transform: uppercase;' : '#2a9fd6;' }}">
                                {{ $object['type'] === 'Invest' ? $object['buildingName'] : $object['images'][0]['caption'] }}
                            </span>
                        @endif
                    </td>
                    <td style="padding-left: 10px;" class="info">
                        <p style="padding-top: 0; margin-top: 0;">Лот {{ $object['id'] }}</p>
                        @if ($object['type'] === 'Invest')
                            <p style="margin-top: 0.7rem;">{{ $object['buildingType']['full'] }}</p>
                        @elseif ($object['type'] === 'Retail')
                            <p>{{ $object['purposeRetail']['full'] }}</p>
                            <p style="line-height: 0.5rem;">{{ $object['isArendator'] ? 'С арендатором' : 'Без арендатора' }}</p>
                            @isset($object['underground'])
                                <p style="margin-top: 0.7rem;">
                                  <img src="{{ storage_path('app/logos/Moscow_Metro.svg') }}" style="height: 1rem; margin-right: 0.4rem;">
                                  <span>{{ $object['underground'] }}</span>
                                </p>
                            @endisset
                        @endif
                        <p style="margin-top: 0.7rem;">{{ $object['district'] }}</p>
                        <p style="line-height: 0.5rem;">{{ $object['address'] }}</p>
                        @if ($object['type'] === 'ZU')
                            <table style="width: 100%; margin-top: 15px;">
                                <tbody>
                                    <tr>
                                        <td style="width: 45%;">
                                            <p style="margin-top: 0;">Земельный участок</p>
                                            @if (isset($object['kadastrNumberZU']))
                                              <p>
                                                @foreach (explode(",", $object['kadastrNumberZU']) as $kadastr)
                                                    <span style="display: block;">{{ trim($kadastr) }}</span>
                                                @endforeach
                                              </p>
                                            @endif
                                            <p>{{ $object['groundS'] }}</p>
                                            <p>{{ $object['purposeZU'] }}</p>
                                            @if ($object['groundPlan']['is'])
                                              <p>{{ $object['groundPlan']['full'] }}</p>
                                            @endif
                                        </td>
                                        @if (isset($object['kadastrNumberOKS']) || isset($object['areaS']) || isset($object['purposeOKS']))
                                          <td style="padding-left: 10px;border-left: 1px solid #6d6c6c;">
                                              <p style="margin-top: 0;">ОКС</p>
                                              @if (isset($object['kadastrNumberOKS']))
                                                <p>
                                                    @foreach (explode(",", $object['kadastrNumberOKS']) as $kadastr)
                                                        <span style="display: block;">{{ trim($kadastr) }}</span>
                                                    @endforeach
                                                </p>
                                              @endif
                                              @if (isset($object['areaS']))
                                                <p>{{ str_replace('м<sup>2</sup>', '', $object['areaS']) }} м<sup>2</sup></p>
                                              @endif
                                              @if (isset($object['purposeOKS']))
                                                <p>{{ $object['purposeOKS'] }}</p>
                                              @endif
                                          </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        @elseif ($object['type'] === 'Invest')
                            <p style="margin-top: 0.7rem;">{{ str_replace('м<sup>2</sup>', '', $object['areaS']) }} м<sup>2</sup></p>
                            @if (isset($object['GAP']))
                              <p style="margin-top: 0.7rem;">
                                ГАП {{ $object['GAP'] }}
                                <span style="font-weight: 600;">₽</span>
                              </p>
                            @endif
                            @if (isset($object['caprate']))
                              <p style="line-height: 0.5rem;">Caprate {{ $object['caprate'] }}%</p>
                            @endif
                        @else
                            <p style="margin-top: 0.7rem;">{{ str_replace('м<sup>2</sup>', '', $object['areaS']) }} м<sup>2</sup></p>
                            @if (isset($object['MAP']))
                              <p style="margin-top: 0.7rem;">
                                МАП {{ $object['MAP'] }}
                                <span style="font-weight: 600;">₽</span>
                              </p>
                            @endif
                            @if (isset($object['payback']))
                              <p style="line-height: 0.5rem;">Окупаемость {{ $object['payback'] }} лет</p>
                            @endif
                        @endif
                        @if (strlen($object['cost']))
                            <p style="font-size: 1.2rem;margin-top: 15px; font-weight: bold;">{{ $object['cost'] }} ₽</p>
                        @else
                            <p style="margin-top: 15px; color: gray;">Информация о цене объекта закрыта</p>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        @foreach ($object['description'] as $description)
            @if (!strlen($description))
                <p> </p>
            @else
                <p style="position: relative; white-space: normal; margin: 0;">{{ $description }}</p>
            @endif
        @endforeach
    </div>
</body>
</html>
