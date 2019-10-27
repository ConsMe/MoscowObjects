<template>
  <div class="h-100">
    <div v-if="isMobileDevice" ref="carouselInner">
      <span class="position-relative d-inline-block">
        <img
          :src="path + object.images[0].filename"
          alt="image"
          class="img-fluid"
          @load="$emit('image-loaded')"
          @click="fancy(0)" />
        <span
          class="text-white pr-3 pl-3 pt-1 pb-1 image-type"
          :class="images[0].captionClass">
          <big>{{ images[0].caption }}</big>
        </span>
      </span>
    </div>
    <div
      id="carouselExampleIndicators"
      class="carousel slide h-100"
      data-ride="false"
      data-interval="false"
      v-else>
      <ol class="carousel-indicators" v-if="images.length > 1">
        <li
          data-target="#carouselExampleIndicators"
          :data-slide-to="i"
          :ref="`indicator${i}`"
          v-for="(image, i) in images"
          :key="image.id">
          </li>
      </ol>
      <div class="carousel-inner position-relative" ref="carouselInner" style="height: 100%;">
        <div
          class="carousel-item h-100 w-100"
          v-for="(image, i) in images"
          :key="image.id"
          :ref="`imageItem${i}`">
          <template v-if="image.style">
            <img
              :src="path + image.filename"
              alt="image"
              class="position-absolute"
              :style="image.style"
              @click="fancy(i)" />
            <span
              class="text-white pr-3 pl-3 pt-1 pb-1 d-inline-block position-absolute"
              v-if="image.caption"
              :class="image.captionClass"
              :style="{right: image.style.right, bottom: image.style.bottom}">
                <big>{{ image.caption }}</big>
            </span>
          </template>
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
  </div>
</template>

<style lang="scss">
  @import '~@fancyapps/fancybox/dist/jquery.fancybox.css';

  .fancybox-caption {
    font-size: 1rem;
  }
  #carouselExampleIndicators {
    .carousel-item img {
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
  props: ['object', 'path'],
  data() {
    return {
      images: JSON.parse(JSON.stringify(this.object.images)),
    };
  },
  computed: {
    fancyItems() {
      return this.images.map(image => ({
        src: this.path + image.filename,
        type: 'image',
        opts: image.caption ? { caption: image.caption } : {},
      }));
    },
    isMobileDevice() {
      return this.$store.getters.isMobileDevice;
    },
  },
  mounted() {
    this.activateFirstImage();
    this.getImagePosition();
  },
  updated() {
    this.activateFirstImage();
  },
  beforeDestroy() {
    $.fancybox.destroy();
  },
  methods: {
    activateFirstImage() {
      $(this.$refs.imageItem0).addClass('active');
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
    getImagePosition() {
      this.images.forEach((image, i) => {
        const [imageWidth, imageHeight] = image.big_image_size.split(',').map(size => parseInt(size, 10));
        const wrapWidth = this.$refs.carouselInner.offsetWidth;
        const wrapHeight = this.$refs.carouselInner.offsetHeight;
        const rateX = wrapWidth / imageWidth;
        const rateY = wrapHeight / imageHeight;
        const rate = Math.min(rateX, rateY);
        const newWidth = Math.round(imageWidth * rate);
        const newHeight = Math.round(imageHeight * rate);
        const bottom = Math.round((wrapHeight - newHeight) / 2);
        const right = Math.round((wrapWidth - newWidth) / 2);
        const style = {
          right: `${right}px`,
          width: `${newWidth}px`,
          height: `${newHeight}px`,
          bottom: `${bottom}px`,
        };
        let captionClass = ['bg-primary'];
        if (this.object.type === 'Invest' && i === 0) {
          captionClass = ['bg-danger', 'text-uppercase'];
          this.$set(this.images[i], 'caption', this.object.buildingName);
        }
        this.$set(this.images[i], 'style', style);
        this.$set(this.images[i], 'captionClass', captionClass);
      });
    },
  },
};
</script>
