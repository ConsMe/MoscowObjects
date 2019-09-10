<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <style>
        @font-face {
            font-family: "Roboto";
            src: url("{{ public_path('pdf/fonts/Roboto-Regular.ttf') }}") format("truetype");
            font-style: normal;
            font-weight: normal;
        }
        body {
            font-family: Roboto;
            position: relative;
        }
        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    {{-- <div class="row">
        <div class="col-8">
            <div class="row">
            <div class="col-2">

            </div>
            <div class="col-2"></div>
            </div>
        </div>
        <div class="col-4">
            <p>Привет</p>
        </div>
    </div> --}}
    <table style="border: 1px solid black;width: 100%; height: 99%;">
        <tbody>
            <tr style="">
                <td style="width: 65%; vertical-align: top;">
                    <table style="border: 1px solid black; width: 100%;">
                        <tbody>
                            <tr>
                                <td style="width: 50%;border: 1px solid black;">
                                    <img
                                      src="{{ storage_path(env('SMALL_IMAGES_PATH')).'r7X0AKv3sJ2DGAaAlSnfQki8zPGd6GkOhgEpgmii.jpg' }}"
                                      style="width: 330px;">
                                </td>
                                <td>
                                    <p>Лот 2</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="background-image: url({{storage_path(env('SMALL_IMAGES_PATH')).'r7X0AKv3sJ2DGAaAlSnfQki8zPGd6GkOhgEpgmii.jpg'}}); background-size: cover; background-position: center; border: 1px solid black; height: 99%;">
                    <img
                      src="data:image/png;base64, {{ $b64_img }}"
                      style="width: 360px;">
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
