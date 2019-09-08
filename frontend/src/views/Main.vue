<template>
  <div class="main-wrap">
    <yandex-map />
    <div class="content">
      <div>
        <filter-block v-show="blocksVisibility.FilterBlock" />
        <object-block
          v-if="blocksVisibility.ObjectBlock"
        />
        <objects-list-block
          v-if="blocksVisibility.ObjectsListBlock && objects.length"
        />
        <building-types-markers
          v-show="currentCategorySlug === 'Invest'"
        />
        <object-full-info
          v-if="blocksVisibility.ObjectFullInfo"
        />
      </div>
    </div>
  </div>
</template>

<style lang="scss">
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
import ObjectsListBlock from '../components/ObjectsListBlock.vue';
import BuildingTypesMarkers from '../components/BuildingTypesMarkers.vue';
import ObjectFullInfo from '../components/ObjectFullInfo.vue';
import main from '../store_modules/main';

export default {
  components: {
    YandexMap,
    FilterBlock,
    ObjectBlock,
    ObjectsListBlock,
    BuildingTypesMarkers,
    ObjectFullInfo,
  },
  data() {
    return {
      toastr,
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
  },
  watch: {
    objects(nv) {
      if (this.favouritesOn && !nv.length) {
        this.toastr.info('У вас нет избранных объектов');
      }
    },
  },
  beforeCreate() {
    this.$store.dispatch('getAllInitData');
    this.$store.registerModule('main', main);
    this.$store.dispatch('main/getAllInitData');
  },
  beforeDestroy() {
    this.$store.unregisterModule('main');
  },
};
</script>
