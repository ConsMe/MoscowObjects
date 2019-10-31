<template>
  <div class="fast-filters">
    <div
      v-for="(filter, slug, i) in filters"
      :key="slug"
      :data-slug="slug"
      class="d-inline-block dropdown">
      <button
          class="btn text-white pr-2 pl-2 pt-1 pb-1 text-uppercase rounded-0 border-dark"
          type="button"
          :class="['bg-' + filter.bg, i < (filtersLength - 1) ? 'mr-1' : '', isDisabled.includes(slug) ? 'translucent' : '']"
          data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false"
      >{{ filter.short }}</button>
      <div
        class="dropdown-menu dropdown-menu-right p-0"
        :class="{'d-none': selectedFastFilters.includes(slug)}">
        <a
          class="dropdown-item pl-2 pr-2"
          href="/"
          :class="['bg-' + filter.bg]"
          @click.prevent="selectFastFilter(slug)">
          {{ `Выбрать ${filter.buttonName}` }}
        </a>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.fast-filters {
  position: absolute;
  z-index: 1;
  top: 0.2rem;
  left: 60%;
  padding: .25rem;
  background-color: #060606;

  button {
    line-height: normal;
  }
  .translucent {
    opacity: .65;
  }

  @media (min-width: 992px) {
    & > div:hover > .dropdown-menu {
      display: block;
    }
    .dropdown-menu {
      margin-top: -.25rem;
    }
    .my-dropdown-menu-center {
      left: 50% !important;
      transform: translateX(-50%);
      text-align: center !important;
    }
  }

  @media (max-width: 991.98px) {
    & {
      left: initial;
      right: 1rem;
    }
  }
}
</style>

<script>
import $ from 'jquery';

export default {
  name: 'FastFilters',
  props: ['filtersInit'],
  computed: {
    selectedFastFilters() {
      return this.$store.state.main.selectedFastFilters;
    },
    isMobileDevice() {
      return this.$store.getters.isMobileDevice;
    },
    filters() {
      return JSON.parse(JSON.stringify(this.filtersInit));
    },
    filtersLength() {
      return Object.keys(this.filters).length;
    },
    isDisabled() {
      return Object.keys(this.filters).filter((slug) => {
        if (!this.selectedFastFilters.length) return false;
        if (this.selectedFastFilters.length === this.filtersLength) return false;
        if (this.selectedFastFilters.includes(slug)) return false;
        return true;
      });
    },
  },
  mounted() {
    this.init();
  },
  beforeUpdate() {
    $('.fast-filters > .dropdown').off('show.bs.dropdown');
  },
  updated() {
    this.init();
  },
  methods: {
    init() {
      $('.fast-filters > .dropdown').on('show.bs.dropdown', (e) => {
        const slug = $(e.target).attr('data-slug');
        if (!this.isMobileDevice) {
          e.preventDefault();
          e.stopPropagation();
          this.selectFastFilter(slug);
        } else if (this.selectedFastFilters.includes(slug)) {
          this.selectFastFilter(slug);
        }
      });
    },
    selectFastFilter(slug) {
      this.$store.commit('main/selectFastFilter', slug);
    },
  },
};
</script>
