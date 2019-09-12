<template>
  <div id="carouselExampleIndicators" class="carousel slide h-100" data-ride="false" data-interval="false">
    <ol class="carousel-indicators" v-if="images.length > 1">
      <li
        data-target="#carouselExampleIndicators"
        :data-slide-to="i"
        :ref="`indicator${i}`"
        v-for="(image, i) in images"
        :key="image.id">
        </li>
    </ol>
    <div class="carousel-inner h-100">
      <div
        class="carousel-item h-100"
         v-for="(image, i) in images"
         :key="image.id"
         :ref="`image${i}`"
         :style="{backgroundImage: `url(${path + image.filename})`}">
      </div>
    </div>
    <a
      class="carousel-control-prev"
      href="#carouselExampleIndicators"
      role="button"
      data-slide="prev"
      v-if="images.length > 1"
    >
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a
      class="carousel-control-next"
      href="#carouselExampleIndicators"
      role="button"
      data-slide="next"
      v-if="images.length > 1"
    >
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</template>

<style lang="scss">
    #carouselExampleIndicators {
      .carousel-item {
        background-position: center center;
        background-size: contain;
        background-repeat: no-repeat;
      }
      .carousel-control-next-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' stroke='gray' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E") !important;
      }
      .carousel-control-prev-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' stroke='gray' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E") !important;
      }
    }
</style>

<script>
import $ from 'jquery';

export default {
  name: 'Carousel',
  props: ['images', 'path'],
  mounted() {
    $(this.$refs.image0).addClass('active');
    $(this.$refs.indicator0).addClass('active');
  },
};
</script>
