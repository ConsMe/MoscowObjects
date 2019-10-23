<template>
  <div :class="isMobileDevice ? 'back-button-relative' : 'back-button-absolute'">
      <router-link
        class="btn btn-outline-dark border-0"
        :class="[isMobileDevice ? 'mb-4' : 'ml-5']"
        :to="{name: currentCategorySlug}">
        <i class="fa fa-reply" aria-hidden="true"></i>
        Вернуться в каталог
      </router-link>
  </div>
</template>

<style lang="scss">
  .back-button-absolute {
    position: absolute;
    top: 1.5rem;
    left: 4rem;
    z-index: 4;
  }
</style>

<script>
export default {
  name: 'BackButton',
  computed: {
    currentCategorySlug() {
      return this.$store.state.currentCategorySlug;
    },
    isMobileDevice() {
      return this.$store.getters.isMobileDevice;
    },
  },
};
</script>
