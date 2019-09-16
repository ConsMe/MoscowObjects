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
            padding: 5px 10px;
        }
        .map-icon {
            display: inline-block;
            min-width: 5.6rem;
            position: absolute;
            top: 50%;
            left: 50%;
            background-color: rgb(33, 6, 68);
            margin-left: 0.8rem;
        }
        .row {
            color: white;
            white-space: nowrap;
            margin: 0;
            box-sizing: border-box;
            padding: 0 0.5rem;
            border: 1px solid white;
            font-size: 92%;
            position: relative;
            display: block;
        }
        .row > div {
            padding: .05rem 0.4rem;
        }
        .row:after, .row:before {
            @if ($object['type'] === 'ZU')
                top: 3.2rem;
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
        }
        .row:before {
            border-color: rgba(194, 225, 245, 0);
            border-top-color: white;
            border-width: 1.8rem .55rem 0 0;
            margin-left: -.05rem;
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
    <table style="width: 100%; height: 99%;">
        <tbody>
            <tr style="">
                <td style="width: 65%;position: relative;white-space: pre-line; padding: 10px;">
                    <table style="border: 0px solid black; width: 100%;">
                        <tbody>
                            <tr>
                                <td style="width: 330px; position: relative;">
                                    <img
                                      src="{{ storage_path(env('BIG_IMAGES_PATH')).$object['images'][0]['filename'] }}"
                                      style="width: 330px;">
                                    <span
                                      class="caption"
                                      style="background-color: {{ $object['type'] === 'ZU' ? '#2a9fd6;' : '#c00; text-transform: uppercase;' }}">
                                        {{ $object['type'] === 'ZU' ? $object['images'][0]['caption'] : $object['buildingName'] }}
                                    </span>
                                </td>
                                <td style="padding-left: 10px;" class="info">
                                    <p style="padding-top: 0; margin-top: 0;">Лот {{ $object['id'] }}</p>
                                    @if ($object['type'] === 'Invest')
                                        <p>{{ $object['buildingType']['full'] }}</p>
                                    @endif
                                    <p>{{ $object['district'] }}</p>
                                    <p>{{ $object['address'] }}</p>
                                    @if ($object['type'] === 'ZU')
                                        <table style="width: 100%; margin-top: 15px;">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 45%;border-right: 1px solid #6d6c6c;">
                                                        <p style="margin-top: 0;">Земельный участок</p>
                                                        <p>{{ $object['kadastrNumberZU'] }}</p>
                                                        <p>{{ $object['groundS'] }}</p>
                                                        <p>{{ $object['purposeZU'] }}</p>
                                                    </td>
                                                    <td style="padding-left: 10px;">
                                                        <p style="margin-top: 0;">ОКС</p>
                                                        <p>{{ $object['kadastrNumberOKS'] }}</p>
                                                        <p>{{ str_replace('м<sup>2</sup>', '', $object['areaS']) }} м<sup>2</sup></p>
                                                        <p>{{ $object['purposeOKS'] }}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        <p>{{ str_replace('м<sup>2</sup>', '', $object['areaS']) }} м<sup>2</sup></p>
                                        <p>{{ $object['groundS'] }}</p>
                                        <p>ГАП {{ $object['GAP'] }} Р</p>
                                        <p>Caprate {{ $object['caprate'] }}%</p>
                                    @endif
                                    @if (strlen($object['cost']))
                                        <p style="font-size: 1.2rem;margin-top: 15px; font-weight: bold;">{{ $object['cost'] }} Р</p>
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
                </td>
                <td style="padding: 10px; position: relative;">
                    <img
                      src="data:image/png;base64, {{ $b64_img }}"
                      style="width: 350px;">
                    <div class="map-icon" style="margin-top: {{ $object['type'] === 'ZU' ? '-8.4rem;' : '-7rem;' }}">
                            @if ($object['type'] === 'ZU')
                                <div class="row">
                                    <div style="text: center; border-bottom: 1px solid gray; font-size: 0.8rem;">{{ $object['groundS'] }}</div>
                                    <div style="text: center;font-size: 0.7rem; padding-bottom: 0.15rem;">{{ str_replace('м<sup>2</sup>', '', $object['areaS']) }} м<sup>2</sup></div>
                                </div>
                            @else
                                <div class="row" style="background-color: #c00;">
                                    <div style="padding-bottom: 0.3rem; text-transform: uppercase;font-size: 0.8rem;">{{ $object['buildingName'] }}</div>
                                </div>
                            @endif
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
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
</body>
</html>
