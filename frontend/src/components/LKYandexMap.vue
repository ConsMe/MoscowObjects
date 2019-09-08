<template>
    <div id="map" :style="style"></div>
</template>

<script>
import toastr from './elements/toastr';

export default {
  name: 'LKYandexMap',
  props: ['address', 'object'],
  data() {
    return {
      map: null,
      point: null,
    };
  },
  computed: {
    favoritesOffsetLeft() {
      return this.$store.state.favoritesOffsetLeft;
    },
    style() {
      return {
        left: `calc(${this.favoritesOffsetLeft} - 15px)`,
        width: `calc(100% - ${this.favoritesOffsetLeft} + 15px)`,
      };
    },
    isYmapsReady() {
      return this.$store.state.lk.isYmapReady.isReady;
    },
    coordinates() {
      return this.object.coordinates;
    },
  },
  watch: {
    coordinates(nv) {
      if (typeof nv === 'object' && nv.length && this.map) {
        this.setPoint(nv);
      }
    },
    address(nv) {
      if (!nv.length) return;
      if (!this.object.district.length) {
        toastr.warning('Выберите субъект');
      } else if (nv.length < 3) {
        toastr.warning('Адрес слишком короткий');
      } else {
        let subject = 'Москва, ';
        if (this.object.location === 'MO') {
          subject = 'Московская область, ';
        }
        ymaps.geocode(subject + nv, {
          results: 1,
        }).then((res) => {
          const firstGeoObject = res.geoObjects.get(0);
          const coordinates = firstGeoObject.geometry.getCoordinates();
          this.$emit('set-coordinates', coordinates);
          this.setPoint(coordinates);
        });
      }
      this.$emit('reset-search-address');
    },
  },
  mounted() {
    if (this.isYmapsReady) {
      this.init();
    } else {
      this.$watch('isYmapsReady', (nv) => {
        if (nv) this.init();
      });
    }
  },
  beforeDestroy() {
    this.map.geoObjects.removeAll();
    this.map.destroy();
  },
  methods: {
    init() {
      this.map = new ymaps.Map('map', {
        center: [55.76141, 37.629708],
        zoom: 12,
        controls: ['typeSelector', 'zoomControl'],
      });
      if (typeof this.coordinates === 'object' && this.coordinates.length) this.setPoint(this.coordinates);
    },
    setPoint(coordinates) {
      if (!this.point) {
        this.point = new ymaps.Placemark(coordinates, {}, {
          preset: 'islands#nightDotIcon',
          cursor: 'pointer',
          draggable: true,
        });
        this.map.geoObjects.add(this.point);
        this.point.events.add('dragend', () => {
          const pointCoordinates = this.point.geometry.getCoordinates();
          this.$emit('set-coordinates', pointCoordinates);
        });
      } else {
        this.point.geometry.setCoordinates(coordinates);
      }
      const zoom = this.map.getZoom();
      this.map.setCenter(coordinates, zoom, { duration: 500 });
    },
  },
};
</script>

<style lang="scss">
.lk-object {
  #map {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 0;
  }
}
</style>
