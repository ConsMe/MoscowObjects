<template>
  <p class="mb-0 text-white">
    <big v-if="objectInfoVisibility[object.id].showPrice">
      {{ object.cost }}
      <strong>₽</strong>
    </big>
    <span
      v-else-if="priceMessage"
      class="text-dark"
    >{{ priceMessage }}</span>
  </p>
</template>

<script>
export default {
  name: 'ObjectPrice',
  props: ['object', 'isMobileDevice'],
  computed: {
    objectInfoVisibility() {
      return this.$store.getters['main/objectInfoVisibility'];
    },
    priceMessage() {
      return this.isMobileDevice ? this.objectInfoVisibility[this.object.id].priceMessageShort
        : this.objectInfoVisibility[this.object.id].priceMessage;
    },
  },
};
</script>
