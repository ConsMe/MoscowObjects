<template>
  <div id="app" class="p-0" :style="appStyle">
    <nav-bar />
    <transition name="fade" mode="out-in">
      <router-view />
    </transition>
  </div>
</template>

<style lang="scss">
@import "./assets/css/_variables.scss";
@import "~bootstrap/scss/bootstrap";
@import "./assets/css/_bootswatch.scss";
$fa-font-path: "~font-awesome/fonts";
@import "~font-awesome/scss/font-awesome";
@import "./assets/css/toastr.scss";

html {
  font-size: .7rem;
}
@media (min-width: 1281px){
  html {
    font-size: .8rem;
  }
}
@media (min-width: 1400px){
  html {
    font-size: .85rem;
  }
}
@media (min-width: 1700px){
  html {
    font-size: 1rem;
  }
}
#app {
    position: absolute;
    height: 100%;
    width: 100%;
    box-sizing: border-box;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.main-wrap {
  display: flex;
  flex: 1;
  position: relative;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .2s;
  transition-delay: 0ms;
  transition-timing-function: linear;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
#toast-container, #toast-container2 {
  & > div {
    opacity: 1;
  }
  span.action {
    text-decoration: underline;
  }
}
#toast-container2 {
  left: 22%;
}
.toast {
  line-height: 0.875rem !important;
  margin-bottom: 0 !important;
  border: 0 !important;
}
</style>

<script>
import 'bootstrap';
import NavBar from './components/NavBar.vue';

export default {
  components: {
    NavBar,
  },
  computed: {
    appStyle() {
      if (!this.$store.state.main) return null;
      return this.$store.getters['main/mobileHeightStyles'].appStyle;
    },
  },
};
</script>
