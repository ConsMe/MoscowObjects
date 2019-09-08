<template>
  <div class="filter-block text-left" ref="filterblock">
    <div class="row ml-0 mr-0 pb-1">
      <div class="col">
        <div class="form-group">
          <div v-for="(filter, name) in filters" :key="name">
            <label class="control-label mt-3 mb-0">
              <span class="text-uppercase">{{ filter.label }}</span>
            </label>
            <div v-if="filter.type == 'checkbox'">
              <div
                class="custom-control custom-checkbox"
                v-for="value in filter.values"
                :key="value.id"
              >
                <input
                  type="checkbox"
                  class="custom-control-input"
                  :id="name + value.id"
                  :value="value.slug"
                  v-model="filter.value"
                />
                <label class="custom-control-label" :for="name + value.id">{{ value.title }}</label>
              </div>
            </div>
            <div v-else-if="filter.type == 'interval'">
              <form>
                <div class="row no-gutters">
                  <div class="col col-auto my-label-bottom">
                    <label class="control-label mb-0">от</label>
                  </div>
                  <div class="col">
                    <input
                      type="text"
                      class="form-control form-control-sm bg-transparent text-white p-0 text-right rounded-0 pr-1 pl-1"
                      v-model="filter.values.from"
                      size="5"
                    />
                  </div>
                  <div class="col col-auto my-label-bottom">
                    <label class="control-label mb-0">до</label>
                  </div>
                  <div class="col">
                    <input
                      type="text"
                      class="form-control form-control-sm bg-transparent text-white p-0 text-right rounded-0 pl-1"
                      v-model="filter.values.to"
                    />
                  </div>
                  <div class="col col-auto my-label-bottom">
                    <label
                      class="control-label ml-1 mb-0"
                      v-html="filter.unit"
                      v-if="name !== 'cost'"
                    ></label>
                    <select
                      class="custom-select d-inline-block text-secondary border-white ml-1 rounded-0"
                      v-else
                      v-model="currency"
                    >
                      <option value="rouble">&#8381;</option>
                      <option value="dollar">$</option>
                      <option value="euro">&#8364;</option>
                    </select>
                  </div>
                </div>
              </form>
            </div>
            <div v-else-if="filter.type == 'radio'">
              <div
                class="custom-control custom-radio"
                v-for="value in filter.values"
                :key="value.id"
              >
                <input
                  type="radio"
                  class="custom-control-input"
                  :id="name + value.id"
                  :value="value.slug"
                  v-model="filter.value"
                />
                <label class="custom-control-label" :for="name + value.id">{{ value.title }}</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button
      class="btn btn-block btn-primary text-uppercase rounded-0 btn-lg justify-content-center"
      @click="applyFilter"
    >Применить</button>
  </div>
</template>

<style lang="scss">
@import "../assets/css/_variables.scss";

.filter-block {
  position: absolute;
  right: 0;
  width: auto;
  z-index: 2;
  background: #060606;
  height: 100%;
  display: flex;
  flex-direction: column;

  .custom-select {
    height: 100%;
    padding: 0;
    text-align-last: center;
    background: transparent;
    width: 1.5rem;
    margin-right: -0.5rem;
    color: $gray-500 !important;
    border-color: $gray-500 !important;
  }
}
.filter-block > .row {
  overflow-y: auto;
  flex: 1;
}
.filter-block > .row::-webkit-scrollbar {
  background: transparent;
  width: 0.3rem;
}
.filter-block > .row::-webkit-scrollbar-thumb {
  background: #888;
}
.filter-block > button {
  align-self: end;
  display: flex;
  flex-direction: row;
}
.my-label-bottom {
  display: flex;
  align-items: center;
}
input[type="text"] {
  border-bottom: 1px solid #888;
}
</style>

<script>
import toastr from './elements/toastr';
import filtersTemplate from '../assets/data/filters';

export default {
  name: 'FilterBlock',
  data() {
    return {
      filters: JSON.parse(JSON.stringify(filtersTemplate)),
      currency: 'rouble',
      toastr,
    };
  },
  computed: {
    filterWidth() {
      return this.$store.state.filterWidth;
    },
    objects() {
      return this.$store.getters['main/objects'];
    },
    filtersOn() {
      return this.$store.state.main.filtersOn;
    },
    currentCategorySlug() {
      return this.$store.state.currentCategorySlug;
    },
  },
  mounted() {
    this.$refs.filterblock.style.width = `${this.filterWidth}px`;
    const { filters } = this.$store.state.main;
    if (filters && Object.keys(filters).length) this.filters = JSON.parse(JSON.stringify(filters));
  },
  watch: {
    filterWidth(nv) {
      this.$refs.filterblock.style.width = `${nv}px`;
    },
    objects(nv) {
      if (this.filtersOn && !nv.length) {
        this.toastr.info('Объекты по заданным условиям не найдены');
      }
    },
    currentCategorySlug() {
      this.$store.commit('main/toggleBlocksVisibility', {
        block: 'FilterBlock',
        visible: false,
      });
    },
  },
  methods: {
    applyFilter() {
      const filters = JSON.parse(JSON.stringify(this.filters));
      Object.keys(filters).forEach((name) => {
        const filter = filters[name];
        if (filter.type === 'interval') {
          const from = parseFloat(filters[name].values.from.replace(',', '.'));
          const to = parseFloat(filters[name].values.to.replace(',', '.'));
          filters[name].values.from = from;
          filters[name].values.to = to;
        }
      });
      this.$store.commit('main/switchFavoritesState');
      this.$store.commit('main/applyFilter', filters);
      this.$store.commit('main/toggleBlocksVisibility', {
        block: 'FilterBlock',
        visible: false,
      });
    },
  },
};
</script>
