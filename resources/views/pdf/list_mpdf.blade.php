<table autosize="1">
    <thead>
      <tr>
        <th scope="col">{{ $currentCategorySlug === 'ZU' ? '' : 'Название' }}</th>
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
          <th scope="col" class="nowrap">ГАП, Р.</th>
          <th scope="col">Caprate</th>
        @endif
        <th scope="col" class="nowrap">Стоимость, Р.</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($objects as $object)
      <tr>
        <td width="25%"
          style="padding-left: 0;text-align: center;">
            <img src="{{ storage_path(env('SMALL_IMAGES_PATH')).$object['images'][0]['filename'] }}" >
            <span style="color: white; background-color: blue; padding: 20px;">
              {{ $object['images'][0]['caption'] }}
            </span>
        </td>
        <td style="text-align: center;">{{ $object['id'] }}</td>
        <td >{{ $object['district'] }}</td>
        <td >{{ $object['address'] }}</td>
        @if ($currentCategorySlug === 'ZU')
          <td >{{ $object['ZUType'] }}</td>
          <td class="nowrap">{{ $object['groundS'] }}</td>
          <td class="nowrap">
            {{ str_replace('м<sup>2</sup>', '', $object['areaS']) }}
            м<sup>2</sup>
          </td>
          <td >
            {{ $object['ZUType'] === 'ZU' ? $object['purposeZU'] : $object['purposeOKS'] }}
          </td>
          <td >{{ $object['groundPlan'] ? 'Есть' : 'Нет' }}</td>
        @endif
        @if ($currentCategorySlug === 'Invest')
          <td >{{ $object['buildingType']['short'] }}</td>
          <td class="nowrap">
            {{ str_replace('м<sup>2</sup>', '', $object['areaS']) }}
            м<sup>2</sup>
          </td>
          <td class="nowrap">{{ $object['GAP'] }}</td>
          <td >{{ $object['caprate'].'%' }}</td>
        @endif
        <td class="nowrap">
          {{ $object['cost'] }}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
