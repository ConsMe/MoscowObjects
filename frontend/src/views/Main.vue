<template>
  <div class="main-wrap">
    <yandex-map />
    <div class="content">
      <div>
        <filter-block v-show="blocksVisibility.FilterBlock" />
        <object-block
          v-if="blocksVisibility.ObjectBlock && currentObject.type"
        />
        <objects-list-block
          v-if="blocksVisibility.ObjectsListBlock && objects.length"
        />
        <fast-filters
          v-if="['Invest', 'Retail'].includes(currentCategorySlug)"
          :filters-init="fastFiltersInit"
        />
        <object-full-info
          v-if="isObjectFullInfoVisible"
        />
      </div>
    </div>
  </div>
</template>

<style lang="scss">
@import "../assets/css/_variables.scss";

.main-wrap {
  strong {
    font-weight: normal;
  }
}
.content {
  display: flex;
  flex-direction: row;
  flex: 1;
  position: relative;
}
.bounce-enter-active {
  animation-name: bounce-in;
  animation-duration: 0.5s;
  animation-delay: 0.5s;
  animation-iteration-count: 1;
  animation-fill-mode: both;
}
.bounce-leave-active {
  animation: bounce-in 0.5s reverse;
}
.bg-ipn {
  background-color: #0d4678;
  &:hover, &:focus {
    background-color: #0a2238;
  }
  &:disabled, &.disabled {
    opacity: .65;
  }
}
.bg-catering {
  background-color: #783d0d;
  &:hover, &:focus {
    background-color: #582a03;
  }
  &:disabled, &.disabled {
    opacity: .65;
  }
}
.text-black {
  color: $black !important;
}
.btn-yellow {
  background-color: #ffda4c;
  color: black;
  &:hover, &:focus {
    background-color: #ffca00;
    color: black;
  }
  &:disabled, &.disabled {
    background-color: #ffe583;
    color: #525252;
    opacity: 1;
  }
}

@keyframes bounce-in {
  0% {
    transform: translate(-100%);
  }
  100% {
    transform: translate(0);
  }
}
</style>

<script>
import toastr from 'toastr';
import YandexMap from '../components/YandexMap.vue';
import FilterBlock from '../components/FilterBlock.vue';
import ObjectBlock from '../components/ObjectBlock.vue';
import ObjectsListBlock from '../components/ObjectsListBlock/ObjectsListBlock.vue';
import FastFilters from '../components/FastFilters.vue';
import ObjectFullInfo from '../components/ObjectFullInfo.vue';
import buildingTypes from '../assets/data/buildingTypes';
import purposesRetail from '../assets/data/purposesRetail';

export default {
  components: {
    YandexMap,
    FilterBlock,
    ObjectBlock,
    ObjectsListBlock,
    FastFilters,
    ObjectFullInfo,
  },
  data() {
    return {
      toastr,
      buildingTypes,
      purposesRetail,
    };
  },
  computed: {
    currentCategorySlug() {
      return this.$store.state.currentCategorySlug;
    },
    blocksVisibility() {
      return this.$store.state.main.blocksVisibility;
    },
    objects() {
      return this.$store.getters['main/objects'];
    },
    favouritesOn() {
      return this.$store.state.main.favouritesOn;
    },
    currentObject() {
      return this.$store.state.main.currentObject;
    },
    isObjectFullInfoVisible() {
      return this.blocksVisibility.ObjectFullInfo && 'type' in this.currentObject;
    },
    fastFiltersInit() {
      if (this.currentCategorySlug === 'Invest') {
        return this.buildingTypes;
      }
      if (this.currentCategorySlug === 'Retail') {
        return this.purposesRetail;
      }
      return {};
    },
  },
  mounted() {
    if (this.objects.length) this.openFullObjectInfo();
  },
  watch: {
    objects(nv, ov) {
      if (this.favouritesOn && !nv.length) {
        this.toastr.info('У вас нет избранных объектов');
      }
      if (nv.length && !ov.length) {
        this.openFullObjectInfo();
      }
    },
    isObjectFullInfoVisible(nv) {
      if (!nv && this.$route.params.objectId) {
        this.$router.push({ name: this.currentCategorySlug });
      }
    },
  },
  beforeCreate() {
    this.$store.dispatch('getAllInitData');
    this.$store.dispatch('main/getAllInitData');
  },
  beforeRouteEnter(to, from, next) {
    next((vm) => {
      vm.setCurrentCategory();
    });
  },
  beforeRouteUpdate(to, from, next) {
    if (to.params && to.params.objectId) {
      next();
      this.openFullObjectInfo();
    } else {
      this.setCurrentCategory();
      next();
    }
  },
  methods: {
    setCurrentCategory() {
      this.$store.commit('changeCurrentCategorySlug', this.$route.name);
    },
    openFullObjectInfo() {
      const { objectId } = this.$route.params;
      if (!objectId) return;
      const currentObject = this.objects.find(object => object.type === this.currentCategorySlug && object.id.toString() === objectId);
      if (!currentObject) {
        this.$router.push({ name: this.currentCategorySlug });
        toastr.warning('Объект не найден, возможно он был уже удален');
        return;
      }
      if (!Object.keys(this.currentObject).length || (this.currentObject.id !== currentObject.id)) {
        this.$store.commit('main/changeCurrentObject', currentObject);
      }
      this.$store.commit('main/toggleBlocksVisibility', {
        block: 'ObjectFullInfo',
        visible: true,
      });
    },
  },
};
</script>
