<template>
    <div id="map"></div>
</template>

<script>
import $ from 'jquery';

export default {
  name: 'YandexMap',
  data() {
    return {
      map: null,
      collection: null,
      flagTemplate: null,
      iconTemplate: null,
      currentZoom: 15,
      zoomChangeIconType: 11,
      remInPx: 0,
    };
  },
  computed: {
    objects() {
      return this.$store.getters['main/objects'];
    },
    objectCoordinatesForShow() {
      return this.$store.state.main.objectCoordinatesForShow;
    },
    currentObject() {
      return this.$store.state.main.currentObject;
    },
    isYmapsReady() {
      return this.$store.state.main.isYmapReady.isReady;
    },
  },
  mounted() {
    this.remInPx = parseFloat(getComputedStyle(document.documentElement).fontSize);
    if (this.isYmapsReady) {
      this.init();
    } else {
      this.$watch('isYmapsReady', (nv) => {
        if (nv) this.init();
      });
    }
  },
  beforeDestroy() {
    this.collection.removeAll();
    this.map.destroy();
  },
  watch: {
    objectCoordinatesForShow(nv) {
      if (!nv.length) return;
      const bounds = this.map.getBounds();
      const longitudeDifference = bounds[1][1] - bounds[0][1];
      const bodyWidth = window.innerWidth;
      const degreesPerPixel = longitudeDifference / bodyWidth;
      const offsetInPixels = bodyWidth * 0.8 - bodyWidth * 0.5;
      const offsetInDegrees = offsetInPixels * degreesPerPixel;
      const coordinates = JSON.parse(JSON.stringify(nv));
      coordinates[1] -= offsetInDegrees;
      this.map.setCenter(coordinates, this.currentZoom, { duration: 500 });
      this.$store.commit('main/showObjectAtMap', []);
      this.$store.commit('main/toggleBlocksVisibility', { block: 'FilterBlock', visible: false });
    },
    currentObject(nv, ov) {
      if (Object.keys(ov).length) {
        this.collection.each((placemark) => {
          const object = placemark.properties.get('object');
          if (placemark && object.id === ov.id) {
            const element = this.getDomElement(placemark);
            if (element) $(element).find('.row').removeClass('activePlacemark');
          }
        });
      }
      if (Object.keys(nv).length) {
        this.collection.each((placemark) => {
          const object = placemark.properties.get('object');
          if (object.id === nv.id) {
            const element = this.getDomElement(placemark);
            $(element).find('.row').addClass('activePlacemark');
            return false;
          }
          return true;
        });
      }
    },
  },
  methods: {
    init() {
      this.flagTemplate = ymaps.templateLayoutFactory.createClass(
        `<div class="map-icon">
            <div>
                {% if properties.object.type === 'ZU' %}
                  <div class="row mb-0 text-center bg-flag$[properties.isActive]" style="height: 2.5rem;">
                      <div class="col-12">$[properties.object.groundS]</div>
                      <div class="col-12 small">$[properties.object.areaS]</div>
                  </div>
                  <div></div>
                {% elseif properties.object.type === 'Invest' %}
                  <div class="row mb-0 text-center bg-{{ properties.object.buildingType.bg }} p-35$[properties.isActive]">
                      <div class="col-12 text-uppercase p-0">$[properties.object.buildingName]</div>
                  </div>
                  <div></div>
                {% endif %}
            </div>
        </div>`,
      );
      this.iconTemplate = ymaps.templateLayoutFactory.createClass(
        `<i class="fa fa-map-marker text-{{ properties.color }}" style="font-size: 52px;">
        </i>`,
      );
      this.map = new ymaps.Map('map', {
        center: [55.76141, 37.629708],
        zoom: this.currentZoom,
        controls: ['typeSelector', 'zoomControl'],
      });
      this.collection = new ymaps.GeoObjectCollection({});
      this.map.geoObjects.add(this.collection);
      this.watchForZoomChange();
      this.putObjects();
      this.$watch('objects', () => {
        this.collection.removeAll();
        this.putObjects();
      });
    },
    watchForZoomChange() {
      this.map.events.add('boundschange', (event) => {
        const newZoom = event.get('newZoom');
        const oldZoom = event.get('oldZoom');
        if (newZoom !== oldZoom) {
          this.currentZoom = newZoom;
          if (this.currentZoom <= this.zoomChangeIconType && oldZoom <= this.zoomChangeIconType) return;
          if (this.currentZoom > this.zoomChangeIconType && oldZoom > this.zoomChangeIconType) return;
          this.collection.removeAll();
          this.putObjects();
        }
      });
    },
    hoverPlacemark(e) {
      const event = e.get('type');
      const placemark = e.get('target');
      const element = this.getDomElement(placemark);
      const target = $(element).find('.row');
      if (event === 'mouseenter') {
        $(target).addClass('hoverPlacemark');
      } else if (event === 'mouseleave') {
        $(target).removeClass('hoverPlacemark');
      } else if (event === 'click') {
        this.$store.commit('main/changeCurrentObject', placemark.properties.get('object'));
        this.$store.commit('main/toggleBlocksVisibility', {
          block: 'ObjectBlock',
          visible: true,
        });
      }
    },
    getDomElement(placemark) {
      const overlay = placemark.getOverlaySync();
      if (!overlay) return null;
      const layout = overlay.getLayoutSync();
      return layout.getElement();
    },
    putObjects() {
      this.objects.forEach((object) => {
        if (object.coordinates) {
          this.addPlacemark(object);
          return;
        }
        this.getCoordinates(object.address);
      });
    },
    addPlacemark(object) {
      const placemark = this.currentZoom > 11 ? this.getFlagPlacemark(object) : this.getIconPlacemark(object);
      this.collection.add(placemark);
      placemark.events.add(['mouseenter', 'mouseleave', 'click'], e => this.hoverPlacemark(e));
    },
    getFlagPlacemark(object) {
      const coordinates = object.type === 'ZU' ? [[0, 0], [87, Math.round(2.5 * this.remInPx)]]
        : [[0, 0], [87, Math.round(1.5 * this.remInPx)]];
      const iconOffset = object.type === 'ZU' ? [0, (Math.round(4 * this.remInPx) + 2) * -1]
        : [0, (Math.round(3 * this.remInPx) + 2) * -1];
      const placemark = new ymaps.Placemark(
        object.coordinates,
        {
          object,
          hintContent: object.address,
          isActive: object.id === this.currentObject.id ? ' activePlacemark' : '',
        },
        {
          iconLayout: this.flagTemplate,
          iconShape: {
            type: 'Rectangle',
            coordinates,
          },
          iconOffset,
          cursor: 'pointer',
        },
      );
      return placemark;
    },
    getIconPlacemark(object) {
      const placemark = new ymaps.Placemark(
        object.coordinates,
        {
          object,
          hintContent: object.address,
          isActive: object.id === this.currentObject.id ? ' activePlacemark' : '',
        },
        {
          preset: object.type === 'ZU' ? 'islands#nightDotIcon' : `islands#${object.buildingType.icon}`,
          cursor: 'pointer',
        },
      );
      return placemark;
    },
    getCoordinates(address) {},
  },
};
</script>

<style lang="scss">
#map {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}
.map-icon {
    display: inline-block;
    .p-35 {
      padding: .35rem .5rem !important;
    }
}
.map-icon .bg-success:not(.hoverPlacemark, .activePlacemark) {
    background-color: #1aad03 !important;
}
.map-icon > div {
    display: inline-block;
}
.map-icon > div > div:nth-child(1) {
    color: white;
    white-space: nowrap;
    margin: 0;
    box-sizing: border-box;
    cursor: pointer;
    padding: 0.2rem 0.4rem;
    border: 1px solid white;
    font-size: 92%;
}
.bg-flag, .bg-icon {
    background-color: rgb(33, 6, 68) !important;
}
.map-icon > div > div:nth-child(2) {
    display: inline-block;
    height: 1.5rem;
    border-left: 1px solid rgb(33, 6, 68);
    margin-left: 1px;
    margin-top: -1px;
}
.hoverPlacemark, .activePlacemark {
  background-color: #cc374f !important;
}
</style>
