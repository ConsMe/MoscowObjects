<template>
  <div class="building-types-marker">
    <div
      v-for="(buildingType, i)
      in allBuildingTypes"
      :key="i"
      :data-index="i"
      class="d-inline-block dropdown">
      <button
          class="btn text-white pr-2 pl-2 pt-1 pb-1 text-uppercase rounded-0 border-dark"
          type="button"
          :class="['bg-' + buildingType.bg, i < 4 ? 'mr-1' : '', isDisabled[i] ? 'translucent' : '']"
          data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false"
      >{{ buildingType.short }}</button>
      <div
        class="dropdown-menu dropdown-menu-right p-0"
        :class="{'d-none': selectedBuildingTypes.includes(buildingType.short)}">
        <a
          class="dropdown-item pl-2 pr-2"
          href="#"
          :class="['bg-' + buildingType.bg]"
          @click="selectBuildingType(buildingType)">
          {{ `Выбрать ${buttonNames[i]}` }}
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
    buttonNames() {
      return this.allBuildingTypes.map((type) => {
        switch (type.short.toLowerCase()) {
          case 'тц':
            return 'торговые центры';
          case 'мфк':
            return 'многофункциональные комплексы';
          case 'бц':
            return 'бизнес-центры';
          case 'ипн':
            return 'инвестиционные портфели недвижимости';
          case 'го':
            return 'гостиницы';
          default:
            return '';
        }
      });
    },
    selectedBuildingTypes() {
      return this.$store.state.main.selectedBuildingTypes;
    },
    isDisabled() {
      return this.allBuildingTypes.map((type) => {
        if (!this.selectedBuildingTypes.length) return false;
        if (this.selectedBuildingTypes.length === this.allBuildingTypes.length) return false;
        if (this.selectedBuildingTypes.includes(type.short)) return false;
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
      const index = parseInt($(e.target).attr('data-index'), 10);
      const { short } = this.allBuildingTypes[index];
      if (this.selectedBuildingTypes.includes(short)) {
        this.$store.commit('main/selectBuildingType', short);
      }
    });
  },
  methods: {
    selectBuildingType(buildingType) {
      this.$store.commit('main/selectBuildingType', buildingType.short);
    },
  },
};
</script>
