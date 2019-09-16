import buildingTypes from './buildingTypes';

export default {
  ZUType: {
    type: 'checkbox',
    label: 'Тип',
    hidden: 'Invest',
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
  buildingType: {
    type: 'radio',
    label: 'Тип',
    hidden: 'ZU',
    values: [
      {
        id: 0,
        title: 'Не важно',
        slug: 'any',
      },
      ...buildingTypes.map((type, i) => ({
        id: i + 1,
        title: `${type.full} (${type.short})`,
        slug: type.short,
        checked: false,
      })),
    ],
    value: 'any',
  },
  location: {
    type: 'checkbox',
    label: 'Расположение',
    hidden: '',
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
    hidden: 'Invest',
    unit: 'Га',
    maxFractional: 4,
    values: {
      from: '',
      to: '',
    },
  },
  areaS: {
    type: 'interval',
    label: 'Площадь ОКС',
    hidden: '',
    unit: 'м<sup>2</sup>',
    maxFractional: 2,
    values: {
      from: '',
      to: '',
    },
  },
  cost: {
    type: 'interval',
    label: 'Стоимость',
    hidden: '',
    unit: '&#8381;',
    maxFractional: 2,
    currency: 'rouble',
    values: {
      from: '',
      to: '',
    },
  },
  caprate: {
    type: 'interval',
    label: 'Caprate',
    hidden: 'ZU',
    unit: '%',
    maxFractional: 2,
    values: {
      from: '',
      to: '',
    },
  },
  purpose: {
    type: 'radio',
    label: 'Назначение',
    hidden: 'Invest',
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
    hidden: 'Invest',
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
