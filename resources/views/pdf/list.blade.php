<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <style>
        /* @import url('./Roboto-Regular.ttf'); */
        @font-face {
            font-family: "Roboto";
            src: url("{{ public_path('pdf/fonts/Roboto-Regular.ttf') }}") format("truetype");
            font-style: normal;
            font-weight: normal;
        }
        @page {
            margin: 20px;
        }
        body {
            font-family: sans-serif;
            /* font-family: DejaVu Sans; */
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        table {
            border-collapse: collapse;
            position: relative;
        }

        td, th {
            text-align: left;
            font-size: 9px;
            border-bottom: 1px solid black;
            border-top: none;
            font-family: Roboto;
            position: relative;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        th {
            background-color: black;
            color: white;
            font-weight: normal;
        }
        img {
            width: 130px;
            position: relative;
        }
        .nowrap {
            white-space: nowrap;
        }
        .caption {
            position: absolute;
            right: 21px;
            top: 10px;
            display: inline-block;
            color: white;
            padding: 5px 10px;
            /* border-bottom: 1px solid white;
            border-left: 1px solid white; */
        }
    </style>
</head>
<body>
        <table style="width: 100%; position:relative;">
                <thead>
                  <tr>
                    <th scope="col" style="padding-left: 5px;">{{ $currentCategorySlug === 'ZU' ? '' : 'Название' }}</th>
                    <th scope="col">Лот</th>
                    <th scope="col">Субъект</th>
                    <th scope="col">Адрес</th>
                    @if ($currentCategorySlug === 'ZU')
                      <th scope="col">Тип</th>
                      <th scope="col" class="nowrap">S ЗУ</th>
                      <th scope="col" class="nowrap">S ОКС</th>
                      <th scope="col">Назначение</th>
                      <th scope="col">ГПЗУ</th>
                    @endif
                    @if ($currentCategorySlug === 'Invest')
                      <th scope="col">Тип</th>
                      <th scope="col">S</th>
                      <th scope="col" class="nowrap">ГАП, ₽</th>
                      <th scope="col">Caprate</th>
                    @endif
                    <th scope="col" class="nowrap">Стоимость, ₽</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($objects as $object)
                  <tr>
                    <td
                      style="padding-left: 0; width: 150px;">
                        <img src="{{ storage_path(env('SMALL_IMAGES_PATH')).$object['images'][0]['filename'] }}" >
                        @if ($object['images'][0]['caption'] || $currentCategorySlug === 'Invest')
                          <span class="caption" style="background-color: {{ $currentCategorySlug === 'ZU' ? '#2a9fd6' : '#c00' }};">
                            {{ $currentCategorySlug === 'ZU' ? $object['images'][0]['caption'] : $object['buildingName'] }}
                          </span>
                        @endif
                    </td>
                    <td style="text-align: left;">{{ $object['id'] }}</td>
                    <td >{{ $object['district'] }}</td>
                    <td >{{ $object['address'] }}</td>
                    @if ($currentCategorySlug === 'ZU')
                      <td >{{ $object['ZUType'] }}</td>
                      <td class="nowrap">{{ $object['groundS'] }}</td>
                      <td class="nowrap">
                        @isset ($object['areaS'])
                          {{ str_replace('м<sup>2</sup>', '', $object['areaS']) }}
                          м<sup>2</sup>
                        @endisset
                      </td>
                      <td >
                        @isset ($object['purposeOKS'])
                          {{ $object['ZUType'] === 'ZU' ? $object['purposeZU'] : $object['purposeOKS'] }}
                        @endisset
                      </td>
                      <td >{{ $object['groundPlan']['short'] }}</td>
                    @endif
                    @if ($currentCategorySlug === 'Invest')
                      <td >{{ $object['buildingType']['short'] }}</td>
                      <td class="nowrap">
                        {{ str_replace('м<sup>2</sup>', '', $object['areaS']) }}
                        м<sup>2</sup>
                      </td>
                      <td class="nowrap">{{ isset($object['GAP']) ? $object['GAP'] : '' }}</td>
                      <td >{{ isset($object['caprate']) ? $object['caprate'].'%' : '' }}</td>
                    @endif
                    <td class="nowrap">
                      {{ $object['cost'] }}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
</body>
</html>
