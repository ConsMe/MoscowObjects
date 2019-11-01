<template>
  <div :is="tagName">
    <template v-if="!isMobileDevice">
      <th
        v-for="(title, field, i) in fields"
        :key="i"
        scope="col"
        :class="[sort[field] ? `sort-${sort[field]}` : null, field === 'buildingName' ? 'text-right': null]"
        @click="sortTo(field)">
        {{ title ? title : ''}}
      </th>
    </template>
    <template v-else>
      <div class="row ml-0 sort-string-mobile">
        <div class="col-auto d-flex">
          <label for="sortSelect" class="mb-0 align-self-center">Сортировать по:</label>
        </div>
        <div class="col pl-0">
          <select id="sortSelect" class="custom-select" v-model="mobileField">
            <option
              v-for="(option, i) in fieldsWithDirections"
              :key="i"
              :value="{ field: option.field, direction: option.direction }"
              v-html="option.title">
            </option>
          </select>
        </div>
      </div>
    </template>
  </div>
</template>

<style lang="scss">
  .sort-string-mobile {
    .custom-select {
      background-color: transparent;
      color: rgb(234, 234, 234);
      text-align: center;
      background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3e%3cpath fill='%23eaeaea' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right 1rem center/8px 10px;
    }
    label {
      color: rgb(234, 234, 234);
    }
  }
</style>

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
      mobileField: {
        field: 'id',
        direction: 'down',
      },
      isIOS: (/iPad|iPhone|iPod/.test(navigator.platform) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1)) && !window.MSStream,
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
    arrow() {
      return {
        up: this.isIOS ? '&#8593;' : '￪',
        down: this.isIOS ? '&#8595;' : '￬',
      };
    },
    fieldsWithDirections() {
      const fields = [];
      Object.keys(this.fields).forEach((field) => {
        if (!this.fields[field]) return;
        fields.push({ title: `${this.fields[field]} ${this.arrow.down}`, field, direction: 'down' });
        fields.push({ title: `${this.fields[field]} ${this.arrow.up}`, field, direction: 'up' });
      });
      return fields;
    },
  },
  watch: {
    mobileField(nv) {
      this.sortTo(nv.field, nv.direction);
    },
    currentCategorySlug() {
      if (this.isMobileDevice) {
        this.mobileField = {
          field: 'id',
          direction: 'down',
        };
      }
    },
  },
  methods: {
    sortTo(field, direction) {
      if (field === 'image') return;
      let passDirection = direction;
      if (!direction) {
        passDirection = field in this.sort && this.sort[field] === 'down' ? 'up' : 'down';
      }
      this.$emit('sort-to', field, passDirection);
    },
  },
};
</script>
