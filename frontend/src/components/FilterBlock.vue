<template>
  <div class="filter-block text-left shadow" ref="filterblock" :style="{width: filterWidth ? `${filterWidth}px` : '100%'}">
    <div class="row ml-0 mr-0 pb-1 justify-content-center">
      <div class="col col-auto col-lg-12">
        <div class="form-group">
          <div v-for="(filter, name) in filters" :key="name">
            <template v-if="!filter.hidden.includes(currentCategorySlug)">
              <label class="control-label mt-3 mb-0" :class="{'mt-4': filter.label === 'Назначение'}">
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
                        class="form-control bg-transparent text-white p-0 text-right rounded-0 pr-1 pl-1"
                        size="5"
                        v-model="filter.values.from"
                        @keydown="input(filter.values.from, name, $event)"
                        @input="transform(name, 'from', $event)"
                        @blur="cutZeros(name, 'from')"
                        @focus="select"
                      />
                    </div>
                    <div class="col col-auto my-label-bottom">
                      <label class="control-label mb-0">до</label>
                    </div>
                    <div class="col">
                      <input
                        type="text"
                        class="form-control bg-transparent text-white p-0 text-right rounded-0 pl-1"
                        v-model="filter.values.to"
                        @keydown="input(filter.values.to, name, $event)"
                        @input="transform(name, 'to', $event)"
                        @blur="cutZeros(name, 'to')"
                        @focus="select"
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
                        v-model="filters.cost.currency"
                      >
                        <option value="rouble">&#8381;</option>
                        <option value="USD">$</option>
                        <option value="EUR">&#8364;</option>
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
            </template>
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
  z-index: 3;
  background: #060606;
  height: 100%;
  display: flex;
  flex-direction: column;

  .custom-select {
    height: 100%;
    padding: 0 .35rem;
    text-align-last: center;
    background: transparent;
    width: auto;
    margin-right: -0.5rem;
    color: $gray-500 !important;
    border-color: $gray-500 !important;
  }
  input[type="text"] {
    height: auto;
    padding-top: .125rem !important;
    padding-bottom: .125rem !important;
  }
  @media (max-width: 991.98px) {
    &, input[type="text"] {
      font-size: 1.15rem;
    }
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
import 'shim-keyboard-event-key';
import toastr from './elements/toastr';
import filtersTemplate from '../assets/data/filters';

export default {
  name: 'FilterBlock',
  data() {
    return {
      toastr,
      filters: {},
      codes: {
        deleteBackspace: [8, 46],
        arrows: [37, 38, 39, 40],
        homeEnd: [35, 36],
        copyPaste: [67, 86, 88],
      },
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
    singleCodes() {
      return [...this.codes.deleteBackspace, ...this.codes.arrows, ...this.codes.homeEnd];
    },
    selectedFastFilters() {
      return this.$store.state.main.selectedFastFilters;
    },
    isSelectedFastFiltersChanged() {
      return this.$store.state.main.isSelectedFastFiltersChanged;
    },
  },
  mounted() {
    this.getFilters();
  },
  watch: {
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
      this.modifyLabels();
    },
    isSelectedFastFiltersChanged() {
      if (!this.selectedFastFilters.length) {
        this.$store.commit('main/filterReset');
      } else {
        const filter = this.currentCategorySlug === 'Invest' ? 'buildingType' : 'purposeRetail';
        this.filters[filter].value = this.selectedFastFilters.slice(0);
        this.applyFilter();
      }
    },
  },
  methods: {
    getFilters() {
      const filters = Object.keys(this.$store.state.main.filters).length
        ? JSON.parse(JSON.stringify(this.$store.state.main.filters))
        : JSON.parse(JSON.stringify(filtersTemplate));
      this.filters = filters;
      this.modifyLabels();
    },
    modifyLabels() {
      this.filters.areaS.label = this.currentCategorySlug === 'ZU' ? 'Площадь ОКС' : 'Площадь';
    },
    applyFilter() {
      this.$store.commit('main/switchFavoritesState');
      this.$store.commit('main/applyFilter', {
        filters: JSON.parse(JSON.stringify(this.filters)),
        currentCategorySlug: this.currentCategorySlug,
      });
      this.$store.commit('main/toggleBlocksVisibility', {
        block: 'FilterBlock',
        visible: false,
      });
    },
    input(value, filterName, e) {
      if (e.keyCode === 9) return;
      if (e.ctrlKey && this.codes.copyPaste.includes(e.keyCode)) return;
      if (this.singleCodes.includes(e.keyCode)) {
        const caretPosition = e.target.selectionStart;
        if (e.keyCode === 8 && caretPosition > 0 && value.substr(caretPosition - 1, 1) === ' ') {
          e.target.setSelectionRange(caretPosition - 1, caretPosition - 1);
        }
        if (e.keyCode === 46 && value.length > caretPosition && value.substr(caretPosition, 1) === ' ') {
          e.target.setSelectionRange(caretPosition + 1, caretPosition + 1);
        }
        return;
      }
      if (/[\d]/.test(e.key)) {
        if (!new RegExp(`[\\.\\,]\\d{${this.filters[filterName].maxFractional}}`).test(value)) {
          return;
        }
        if (e.target.selectionStart < value.search(/[\\.\\,]/)) {
          return;
        }
      }
      if (/[\\.\\,]/.test(e.key) && !/[\\.\\,]/.test(value) && (value.length - e.target.selectionStart) < this.filters[filterName].maxFractional) return;
      e.preventDefault();
    },
    transform(filterName, parameter, e) {
      const value = this.filters[filterName].values[parameter].replace(/\s/g, '');
      const oldCaretPosition = e.target.selectionStart;
      const oldSpaces = (this.filters[filterName].values[parameter].match(/\s/g) || []).length;
      const numberParts = value.split(/[\\.\\,]/);
      let modifiedNumber = numberParts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
      if (numberParts.length > 1) {
        modifiedNumber += value.substr(-numberParts[1].length - 1);
      }
      this.filters[filterName].values[parameter] = modifiedNumber;
      setTimeout(() => {
        const newSpaces = (this.filters[filterName].values[parameter].match(/\s/g) || []).length;
        let newCaretPosition = oldCaretPosition;
        if (oldSpaces < newSpaces) {
          newCaretPosition += 1;
        } else if (oldSpaces > newSpaces) {
          newCaretPosition = (newCaretPosition - 1) < 0 ? 0 : newCaretPosition - 1;
        }
        e.target.setSelectionRange(newCaretPosition, newCaretPosition);
      }, 0);
    },
    cutZeros(filterName, parameter) {
      this.filters[filterName].values[parameter] = this.filters[filterName].values[parameter].replace(/([\\.\\,][1-9]*)0+$/, '$1');
      this.filters[filterName].values[parameter] = this.filters[filterName].values[parameter].replace(/[\\.\\,]$/, '');
    },
    select(e) {
      e.target.setSelectionRange(0, e.target.value.length);
    },
  },
};
</script>
