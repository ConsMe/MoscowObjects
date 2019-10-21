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
        :style="{backgroundImage: `url(${path + image.filename})`}"
        @click="fancy(i)">
        <!-- <span
            class="bg-danger text-white pr-3 pl-3 pt-1 pb-1 building-name-bottom text-uppercase"
          >
            <big>Example</big>
        </span> -->
        <!-- <img :src="path + image.filename" alt="" class="img-flud"> -->
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
  @import '~@fancyapps/fancybox/dist/jquery.fancybox.css';

  #carouselExampleIndicators {
    .carousel-item {
      background-position: center center;
      background-size: contain;
      background-repeat: no-repeat;
      cursor: zoom-in;
    }
    .carousel-control-next-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' stroke='gray' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E") !important;
    }
    .carousel-control-prev-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' stroke='gray' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E") !important;
    }
    a.carousel-control-next:hover, a.carousel-control-prev:hover {
      background-color: rgba(0, 0, 0, 0.03);
    }
  }
</style>

<script>
import $ from 'jquery';
import '@fancyapps/fancybox/dist/jquery.fancybox.min';

export default {
  name: 'Carousel',
  props: ['images', 'path'],
  computed: {
    fancyItems() {
      return this.images.map(image => ({
        src: this.path + image.filename,
        type: 'image',
      }));
    },
  },
  mounted() {
    this.activateFirstImage();
  },
  updated() {
    this.activateFirstImage();
  },
  beforeDestroy() {
    $.fancybox.destroy();
  },
  methods: {
    activateFirstImage() {
      $(this.$refs.image0).addClass('active');
      $(this.$refs.indicator0).addClass('active');
    },
    fancy(index) {
      $.fancybox.open(this.fancyItems, {
        buttons: ['close'],
        loop: true,
        animationEffect: 'zoom-in-out',
        transitionEffect: 'slide',
      }, index);
    },
  },
};
</script>
