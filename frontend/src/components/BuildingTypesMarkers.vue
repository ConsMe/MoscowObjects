<template>
  <div class="building-types-marker">
    <div
      v-for="(buildingType, slug, i) in allBuildingTypes"
      :key="slug"
      :data-slug="slug"
      class="d-inline-block dropdown">
      <button
          class="btn text-white pr-2 pl-2 pt-1 pb-1 text-uppercase rounded-0 border-dark"
          type="button"
          :class="['bg-' + buildingType.bg, i < 4 ? 'mr-1' : '', isDisabled.includes(slug) ? 'translucent' : '']"
          data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false"
      >{{ buildingType.short }}</button>
      <div
        class="dropdown-menu dropdown-menu-right p-0"
        :class="{'d-none': selectedBuildingTypes.includes(slug)}">
        <a
          class="dropdown-item pl-2 pr-2"
          href="/"
          :class="['bg-' + buildingType.bg]"
          @click.prevent="selectBuildingType(slug)">
          {{ `Выбрать ${buildingType.buttonName}` }}
        </a>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.building-types-marker {
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
import buildingTypes from '../assets/data/buildingTypes';

export default {
  name: 'BuildingTypesMarkers',
  data() {
    return {
      allBuildingTypes: JSON.parse(JSON.stringify(buildingTypes)),
    };
  },
  computed: {
    selectedBuildingTypes() {
      return this.$store.state.main.selectedBuildingTypes;
    },
    isDisabled() {
      return Object.keys(this.allBuildingTypes).filter((slug) => {
        if (!this.selectedBuildingTypes.length) return false;
        if (this.selectedBuildingTypes.length === this.allBuildingTypes.length) return false;
        if (this.selectedBuildingTypes.includes(slug)) return false;
        return true;
      });
    },
    isMobileDevice() {
      return this.$store.getters.isMobileDevice;
    },
  },
  mounted() {
    $('.building-types-marker > .dropdown').on('show.bs.dropdown', (e) => {
      if (!this.isMobileDevice) {
        e.preventDefault();
        e.stopPropagation();
      }
      const slug = $(e.target).attr('data-slug');
      if (this.selectedBuildingTypes.includes(slug)) {
        this.$store.commit('main/selectBuildingType', slug);
      }
    });
  },
  methods: {
    selectBuildingType(slug) {
      this.$store.commit('main/selectBuildingType', slug);
    },
  },
};
</script>
