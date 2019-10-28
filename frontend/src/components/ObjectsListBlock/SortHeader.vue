<template>
  <div :is="tagName">
    <template v-if="!isMobileDevice">
      <th
        v-for="(title, field, i) in fields"
        :key="i"
        scope="col"
        :class="[sort[field] ? `sort-${sort[field]}` : null]"
        @click="$emit('sort-to', field)">
        {{ title ? title : ''}}
      </th>
    </template>
    <template v-else>

    </template>
  </div>
</template>

<script>
export default {
  name: 'SortHeader',
  props: ['isMobileDevice', 'sort'],
  data() {
    return {
      commonFields: {
        id: 'Лот',
        district: 'Субъект',
        address: 'Адрес',
      },
    };
  },
  computed: {
    currentCategorySlug() {
      return this.$store.state.currentCategorySlug;
    },
    tagName() {
      return this.isMobileDevice ? 'div' : 'tr';
    },
    fields() {
      switch (this.currentCategorySlug) {
        case 'ZU':
          return {
            image: null,
            ...this.commonFields,
            ZUType: 'Тип',
            groundS: 'S ЗУ',
            areaS: 'S ОКС',
            purpose: 'Назначение',
            groundPlan: 'ГПЗУ',
            cost: 'Стоимость, ₽',
          };
        case 'Invest':
          return {
            buildingName: 'Название',
            ...this.commonFields,
            type: 'Тип',
            areaS: 'S',
            GAP: 'ГАП, ₽',
            caprate: 'Caprate',
            cost: 'Стоимость, ₽',
          };
        case 'Retail':
          return {
            image: null,
            ...this.commonFields,
            purposeRetail: 'Назначение',
            areaS: 'S',
            MAP: 'МАП, ₽',
            payback: 'Окупаемость',
            cost: 'Стоимость, ₽',
          };
        default:
          return '';
      }
    },
  },
  methods: {
    sortTo() {

    },
  },
};
</script>
