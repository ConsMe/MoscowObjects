<template>
  <div class="lk-wrap bg-white">
    <transition name="fade" mode="out-in">
      <router-view />
    </transition>
  </div>
</template>

<style lang="scss">
@import "../assets/css/_variables.scss";

.lk-wrap {
  overflow-x: hidden;
  overflow-y: auto;
  h3 {
    color: $gray-500 !important;
  }
  .form-control {
    // background-color: rgb(232, 240, 254) !important;
  }
  display: flex;
  flex-direction: row;
  position: relative;
  flex: 1;
}
.lk-wrap::-webkit-scrollbar, .lk-wrap .row::-webkit-scrollbar {
  background: transparent;
  width: 0.3rem;
}
.lk-wrap::-webkit-scrollbar-thumb, .lk-wrap .row::-webkit-scrollbar-thumb {
  background: #888;
}
</style>

<script>
import lk from '../store_modules/lk';


export default {
  name: 'LK',
  beforeCreate() {
    this.$store.registerModule('lk', lk);
  },
  beforeDestroy() {
    this.$store.unregisterModule('lk');
  },
};
</script>
