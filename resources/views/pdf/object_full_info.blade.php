<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <style>
        html {
            font-size: 12px;
        }
        @font-face {
            font-family: "Roboto";
            src: url("{{ public_path('pdf/fonts/Roboto-Regular.ttf') }}") format("truetype");
            font-style: normal;
            font-weight: normal;
        }
        body {
            font-family: Roboto;
            position: relative;
            color: #6d6c6c;
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
            position: absolute;
            top: 50%;
            left: 50%;
            display: inline-block;
            margin-left: 10px;
        }
        .zu-icon {
            background-color: #210644;
            border: 1px solid white;
            display: inline-block;
            height: 40px;
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 0;
            padding-bottom: 0;
            color: white;
            width: auto;
            position: relative;
        }
        .zu-icon div {
            display: block;
            position: relative;
            width: 100%;
        }
        .invest-icon {
            border: 1px solid white;
            display: inline-block;
            height: 25px;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 0;
            padding-bottom: 0;
            color: white;
            width: auto;
            position: relative;
            line-height: 15px;
            text-transform: uppercase;
        }
        .leg {
            display: block;
            height: 18px;
            margin-left: 1px;
            z-index: 1;
            @if ($object['type'] === 'ZU')
                margin-top: -10px;
                border-left: 1px solid #210644;
            @else
                margin-top: -7px;
                border-left: 1px solid #c00;
            @endif
        }
    </style>
</head>
<body>
    <table style="border: 1px solid #8ac3fb;width: 100%; height: 99%;">
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
                                    <p style="font-size: 1.2rem;margin-top: 15px; ">{{ $object['cost'] }} Р</p>
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
                    <div class="map-icon" style="margin-top: {{ $object['type'] === 'ZU' ? '-58px;' : '-43px;' }}">
                            @if ($object['type'] === 'ZU')
                                <div class="zu-icon">
                                    <div style="text: center;">{{ $object['groundS'] }}</div>
                                    <div style="text: center;font-size: 0.8rem;">{{ str_replace('м<sup>2</sup>', '', $object['areaS']) }} м<sup>2</sup></div>
                                </div>
                                <div class="leg"></div>
                            @else
                                <div class="invest-icon" style="background-color: #c00;">
                                    <div>{{ $object['buildingName'] }}</div>
                                </div>
                                <div
                                  class="leg">

                                </div>
                            @endif
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
