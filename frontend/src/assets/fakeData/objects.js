const objectsPre = [
  {
    address: 'улица Петровка, 21с1-2',
    coordinates: [55.765417, 37.615309],
    groundS: '0.22',
    areaS: '9273',
    type: 'ZU',
  },
  {
    address: 'Звонарский переулок, 1', coordinates: [55.764769, 37.62095], groundS: '0.82', areaS: '2078', type: 'Invest', buildingName: 'Лапландия',
  },
  {
    address: 'улица Кузнецкий Мост, 13/9с1', coordinates: [55.762409, 37.623016], groundS: '0.59', areaS: '6249', type: 'ZU',
  },
  {
    address: 'улица Рождественка, 20/8с4', coordinates: [55.766101, 37.624049], groundS: '0.68', areaS: '2165', type: 'Invest', buildingName: 'Новые времена',
  },
  {
    address: 'Мясницкая улица, 1', coordinates: [55.760216, 37.628595], groundS: '0.55', areaS: '8447', type: 'ZU',
  },
  {
    address: 'Большой Златоустинский переулок, 6с1', coordinates: [55.75864, 37.632206], groundS: '0.1', areaS: '5062', type: 'Invest', buildingName: 'Островок',
  },
  {
    address: 'Кривоколенный переулок, 10с5', coordinates: [55.761761, 37.635673], groundS: '0.27', areaS: '3797', type: 'ZU',
  },
  {
    address: 'Милютинский переулок, 16с1', coordinates: [55.764242, 37.632386], groundS: '0.85', areaS: '8404', type: 'Invest', buildingName: 'Каширский',
  },
  {
    address: 'улица Покровка, 10с5', coordinates: [55.7586, 37.644504], groundS: '0.44', areaS: '1427', type: 'ZU',
  },
  {
    address: 'Лялин переулок, 7/2с1', coordinates: [55.759603, 37.652472], groundS: '0.25', areaS: '1364', type: 'Invest', buildingName: 'Космос',
  },
  {
    address: 'Подсосенский переулок, 30', coordinates: [55.75479, 37.65373], groundS: '0.87', areaS: '8802', type: 'ZU',
  },
  {
    address: 'Большой Николоворобинский переулок, 9/11', coordinates: [55.750753, 37.64931], groundS: '0.74', areaS: '6009', type: 'Invest', buildingName: 'Москва Plaza',
  },
  {
    address: 'Николоямская улица, 13с2', coordinates: [55.747991, 37.651987], groundS: '0.01', areaS: '8449', type: 'ZU',
  },
  {
    address: 'Гончарная улица, 26к1', coordinates: [55.743015, 37.649031], groundS: '0.07', areaS: '6018', type: 'Invest', buildingName: 'Айсберг',
  },
  {
    address: 'Рабочая улица, 35к2', coordinates: [55.742255, 37.687758], groundS: '0.64', areaS: '4163', type: 'ZU',
  },
  {
    address: 'Нижегородская улица, 32сБ', coordinates: [55.736635, 37.689527], groundS: '0.74', areaS: '7252', type: 'Invest', buildingName: 'Европа',
  },
  {
    address: 'Угрешская улица, 2с95', coordinates: [55.713045, 37.691791], groundS: '0.68', areaS: '1226', type: 'ZU',
  },
  {
    address: 'улица Гурьянова, 73', coordinates: [55.678981, 37.717231], groundS: '0.2', areaS: '5339', type: 'Invest', buildingName: 'Галереи Чижова',
  },
  {
    address: 'Батюнинский проезд, 15с1', coordinates: [55.666442, 37.697675], groundS: '0.29', areaS: '8059', type: 'Invest', buildingName: 'Сити Град',
  },
  {
    address: 'Каширское шоссе, 44к2', coordinates: [55.647595, 37.66221], groundS: '0.15', areaS: '8721', type: 'ZU',
  },
  {
    address: 'улица Москворечье, 4к5', coordinates: [55.643688, 37.650729], groundS: '0.6', areaS: '2598', type: 'Invest', buildingName: 'Восток',
  },
];

const buildingTypes = [
  {
    short: 'ТЦ', full: 'Торговый центр', bg: 'primary', icon: 'blueDotIcon',
  },
  {
    short: 'МФК', full: 'Многофункциональный комплекс', bg: 'info', icon: 'violetDotIcon',
  },
  {
    short: 'БЦ', full: 'Бизнес-центр', bg: 'success', icon: 'darkGreenDotIcon',
  },
  {
    short: 'ИПН', full: 'Инвестиционный портфель недвижимости', bg: 'ipn', icon: 'darkBlueDotIcon',
  },
  {
    short: 'ГО', full: 'Гостиница', bg: 'warning', icon: 'orangeDotIcon',
  },
];

const objects = objectsPre.map((object, i) => {
  const modifiedObject = object;
  const id = i + 1;
  const dopParamaters = {
    id,
    lot: Math.round(Math.random() * 10000).toString().padEnd(4, '0'),
    district: 'Москва, ЦАО',
    cost: Math.round(Math.random() * 100) * 100000000,
    location: 'Moscow',
  };
  modifiedObject.areaS = parseInt(object.areaS, 10) * 1000;
  modifiedObject.groundS = parseFloat(object.groundS.toString() + Math.round(Math.random() * 1000).toString());
  if (object.type === 'Invest') {
    dopParamaters.buildingType = buildingTypes[Math.floor(Math.random() * buildingTypes.length)];
    dopParamaters.GAP = Math.round(Math.random() * 100) * 10000;
    dopParamaters.caprate = Math.round(Math.random() * 50);
    dopParamaters.image = '/fakeImg/building.jpeg';
  } else if (object.type === 'ZU') {
    dopParamaters.kadastrNumber = '77:01:0004012';
    dopParamaters.purpose = Math.random() > 0.5 ? 'Жилое' : 'Нежилое';
    dopParamaters.groundPlan = Math.random() > 0.5;
    dopParamaters.image = '/fakeImg/ZU.jpg';
    dopParamaters.imageType = Math.random() > 0.5 ? 'Проект' : 'Фото';
    dopParamaters.ZUType = Math.random() > 0.5 ? 'ОКС' : 'ЗУ';
  }
  return Object.assign(modifiedObject, dopParamaters);
});

const favourites = objects.map(object => object.id).filter(() => Math.random() > 0.5);

export { objects, buildingTypes, favourites };
