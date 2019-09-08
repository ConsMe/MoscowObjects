export default {
  ZUType: {
    type: 'checkbox',
    label: 'Тип',
    values: [
      {
        id: 0,
        title: 'Земельные участки (ЗУ)',
        slug: 'ЗУ',
        checked: false,
      },
      {
        id: 1,
        title: 'ОКС под реконструкцию',
        slug: 'ОКС',
        checked: false,
      },
    ],
    value: [],
  },
  location: {
    type: 'checkbox',
    label: 'Расположение',
    values: [
      {
        id: 0,
        title: 'Москва',
        slug: 'Moscow',
        checked: false,
      },
      {
        id: 1,
        title: 'Новая Москва',
        slug: 'New_Moscow',
        checked: false,
      },
      {
        id: 2,
        title: 'Московская область (МО)',
        slug: 'MO',
        checked: false,
      },
    ],
    value: [],
  },
  groundS: {
    type: 'interval',
    label: 'Площадь ЗУ',
    unit: 'Га',
    values: {
      from: '',
      to: '',
    },
  },
  areaS: {
    type: 'interval',
    label: 'Площадь ОКС',
    unit: 'м<sup>2</sup>',
    values: {
      from: '',
      to: '',
    },
  },
  cost: {
    type: 'interval',
    label: 'Стоимость',
    unit: '&#8381;',
    values: {
      from: '',
      to: '',
    },
  },
  purpose: {
    type: 'radio',
    label: 'Назначение',
    values: [
      {
        id: 0,
        title: 'Не важно',
        slug: 'any',
      },
      {
        id: 1,
        title: 'Жилое',
        slug: 'Жилое',
      },
      {
        id: 2,
        title: 'Апартаменты',
        slug: 'Апартаменты',
      },
      {
        id: 3,
        title: 'Нежилое',
        slug: 'Нежилое',
      },
    ],
    value: 'any',
  },
  groundPlan: {
    type: 'radio',
    label: 'Наличие ГПЗУ',
    values: [
      {
        id: 0,
        title: 'Не важно',
        slug: 'any',
      },
      {
        id: 1,
        title: 'Есть',
        slug: true,
      },
      {
        id: 2,
        title: 'Нет',
        slug: false,
      },
    ],
    value: 'any',
  },
};
