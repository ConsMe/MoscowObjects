import buildingTypes from './buildingTypes';
import purposesRetail from './purposesRetail';

export default {
  ZUType: {
    type: 'checkbox',
    label: 'Тип',
    hidden: ['Invest', 'Retail'],
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
  isArendator: {
    type: 'checkbox',
    label: 'Наличие арендатора',
    hidden: ['ZU', 'Invest'],
    values: [
      {
        id: 0,
        title: 'С арендатором',
        slug: true,
      },
      {
        id: 1,
        title: 'Без арендатора',
        slug: false,
      },
    ],
    value: [],
  },
  purposeRetail: {
    type: 'checkbox',
    label: 'Назначение помещения',
    hidden: ['ZU', 'Invest'],
    values: purposesRetail.map((purpose, i) => ({
      id: i + 1,
      title: purpose.full,
      slug: purpose.slug,
      checked: false,
    })),
    value: [],
  },
  buildingType: {
    type: 'checkbox',
    label: 'Тип',
    hidden: ['ZU', 'Retail'],
    values: buildingTypes.map((type, i) => ({
      id: i + 1,
      title: `${type.full} (${type.short})`,
      slug: type.short,
      checked: false,
    })),
    value: [],
  },
  location: {
    type: 'checkbox',
    label: 'Расположение',
    hidden: ['Retail'],
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
    hidden: ['Invest', 'Retail'],
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
    hidden: [''],
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
    hidden: [''],
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
    hidden: ['ZU', 'Retail'],
    unit: '%',
    maxFractional: 2,
    values: {
      from: '',
      to: '',
    },
  },
  payback: {
    type: 'interval',
    label: 'Окупаемость',
    hidden: ['ZU', 'Invest'],
    unit: 'лет',
    maxFractional: 1,
    values: {
      from: '',
      to: '',
    },
  },
  purpose: {
    type: 'checkbox',
    label: 'Назначение',
    hidden: ['Invest', 'Retail'],
    values: [
      {
        id: 0,
        title: 'Жилое',
        slug: 'Жилое',
      },
      {
        id: 1,
        title: 'Апартаменты',
        slug: 'Апартаменты',
      },
      {
        id: 2,
        title: 'Нежилое',
        slug: 'Нежилое',
      },
    ],
    value: [],
  },
  groundPlan: {
    type: 'checkbox',
    label: 'Наличие ГПЗУ',
    hidden: ['Invest', 'Retail'],
    values: [
      {
        id: 0,
        title: 'Есть',
        slug: true,
      },
      {
        id: 1,
        title: 'Нет',
        slug: false,
      },
      {
        id: 2,
        title: 'В процессе',
        slug: 'in_process',
      },
    ],
    value: [],
  },
};
