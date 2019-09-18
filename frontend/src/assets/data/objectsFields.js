const any = [
  'type',
  'address',
  'areaS',
  'groundS',
  'cost',
  'costCurrency',
  'responsible',
  'description',
  'coordinates',
  'location',
  'district',
  'images',
  'docs',
  'only_auth',
  'price_admins_only',
  'object_admins_only',
  'hide_company_info_in_tizer',
];

const ZU = [
  'ZUType',
  'kadastrNumberZU',
  'kadastrNumberOKS',
  'purposeZU',
  'purposeOKS',
  'groundPlan',
];

const Invest = [
  'GAP',
  'GAPCurrency',
  'caprate',
  'buildingName',
  'buildingType',
];

const numericFields = [
  'areaS',
  'groundS',
  'cost',
  'GAP',
  'caprate',
];

export default {
  any, ZU, Invest, numericFields,
};
