<template>
    <div id="map"></div>
</template>

<script>
import $ from 'jquery';
import buildingTypes from '../assets/data/buildingTypes';
import purposesRetail from '../assets/data/purposesRetail';

export default {
  name: 'YandexMap',
  data() {
    return {
      map: null,
      collection: null,
      flagTemplate: null,
      currentZoom: 15,
      zoomChangeIconType: 11,
      remInPx: 0,
      oneLineStyle: '',
      buildingTypes,
      purposesRetail,
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
    currentCategorySlug() {
      return this.$store.state.currentCategorySlug;
    },
  },
  mounted() {
    this.remInPx = parseFloat(getComputedStyle(document.documentElement).fontSize);
    const oneLineHeight = `${1.5 * this.remInPx + 2}px`;
    this.oneLineStyle = `height: ${oneLineHeight}; line-height: ${oneLineHeight}; padding: 0`;
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
            if (this.currentZoom <= this.zoomChangeIconType || object.type === 'Retail') {
              const color = this.getIconColor(object);
              placemark.options.set('preset', `islands#${color}`);
            } else {
              const element = this.getDomElement(placemark);
              if (element) $(element).find('.row').removeClass('activePlacemark');
            }
            return false;
          }
          return true;
        });
      }
      if (Object.keys(nv).length && this.collection) {
        this.collection.each((placemark) => {
          const object = placemark.properties.get('object');
          if (object.id === nv.id) {
            if (this.currentZoom <= this.zoomChangeIconType || object.type === 'Retail') {
              placemark.options.set('preset', 'islands#redDotIcon');
            } else {
              const element = this.getDomElement(placemark);
              $(element).find('.row').addClass('activePlacemark');
            }
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
            {% if properties.object.type === 'ZU' %}
                <div class="row mb-0 text-center bg-flag$[properties.isActive]">
                    {% if properties.object.areaS %}
                      <div class="col-12">$[properties.object.groundS]</div>
                      <div class="col-12 with-border small">$[properties.object.areaS]</div>
                    {% else %}
                      <div class="col-12" style="$[properties.oneLineStyle]">$[properties.object.groundS]</div>
                    {% endif %}
                </div>
            {% elseif properties.object.type === 'Invest' %}
                <div class="row mb-0 text-center bg-{{ properties.bg }} p-35$[properties.isActive]">
                    <div class="col-12 text-uppercase p-0">$[properties.object.buildingName]</div>
                </div>
            {% endif %}
        </div>`,
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
      const object = placemark.properties.get('object');
      if (event === 'click') {
        this.$store.commit('main/changeCurrentObject', object);
        this.$store.commit('main/toggleBlocksVisibility', {
          block: 'ObjectBlock',
          visible: true,
        });
        return;
      }
      if (this.currentZoom <= this.zoomChangeIconType || object.type === 'Retail') {
        if (event === 'mouseenter') {
          placemark.options.set('preset', 'islands#redDotIcon');
        } else if (event === 'mouseleave') {
          if (object.id === this.currentObject.id) return;
          const color = this.getIconColor(object);
          placemark.options.set('preset', `islands#${color}`);
        }
        return;
      }
      const element = this.getDomElement(placemark);
      const target = $(element).find('.row');
      if (event === 'mouseenter') {
        $(target).addClass('hoverPlacemark');
      } else if (event === 'mouseleave') {
        $(target).removeClass('hoverPlacemark');
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
        }
      });
    },
    addPlacemark(object) {
      const placemark = this.currentZoom > 11 ? this.getFlagPlacemark(object) : this.getIconPlacemark(object);
      this.collection.add(placemark);
      placemark.events.add(['mouseenter', 'mouseleave', 'click'], e => this.hoverPlacemark(e));
    },
    getFlagPlacemark(object) {
      const coordinates = object.type === 'ZU' && object.areaS ? [[0, 0], [Math.round(5.6 * this.remInPx), Math.round(2.375 * this.remInPx)]]
        : [[0, 0], [87, Math.round(1.5 * this.remInPx)]];
      const iconOffset = object.type === 'ZU' && object.areaS ? [0, (Math.round(3.875 * this.remInPx)) * -1]
        : [0, (Math.round(3 * this.remInPx) + 2) * -1];
      let options;
      if (object.type === 'Retail') {
        options = {
          preset: object.id === this.currentObject.id ? 'islands#redDotIcon' : `islands#${this.purposesRetail[object.purposeRetail].icon}`,
          cursor: 'pointer',
        };
      } else {
        options = {
          iconLayout: this.flagTemplate,
          iconShape: {
            type: 'Rectangle',
            coordinates,
          },
          iconOffset,
          cursor: 'pointer',
        };
      }
      const placemark = new ymaps.Placemark(
        object.coordinates,
        {
          object,
          hintContent: object.address,
          isActive: object.id === this.currentObject.id ? ' activePlacemark' : '',
          oneLineStyle: this.oneLineStyle,
          bg: object.type === 'Invest' ? this.buildingTypes[object.buildingType].bg : null,
        },
        options,
      );
      return placemark;
    },
    getIconPlacemark(object) {
      const color = object.id === this.currentObject.id ? 'redDotIcon' : this.getIconColor(object);
      const placemark = new ymaps.Placemark(
        object.coordinates,
        {
          object,
          hintContent: object.address,
          isActive: object.id === this.currentObject.id ? ' activePlacemark' : '',
        },
        {
          preset: `islands#${color}`,
          cursor: 'pointer',
        },
      );
      return placemark;
    },
    getIconColor(object) {
      let color = 'grayDotIcon';
      switch (object.type) {
        case 'ZU':
          color = 'nightDotIcon';
          break;
        case 'Invest':
          color = this.buildingTypes[object.buildingType].icon;
          break;
        case 'Retail':
          color = this.purposesRetail[object.purposeRetail].icon;
          break;
        default:
          break;
      }
      return color;
    },
  },
};
</script>

<style lang="scss">
@import "../assets/css/_variables.scss";

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
  box-shadow: 5px 5px 5px 0px rgba(0, 0, 0, 0.51);
  min-width: 5.6rem;
  .p-35 {
    padding: .35rem .5rem !important;
  }
  .bg-success:not(.hoverPlacemark, .activePlacemark) {
    background-color: #1aad03 !important;
  }
  .row {
    color: white;
    white-space: nowrap;
    margin: 0;
    box-sizing: border-box;
    cursor: pointer;
    padding: 0 0.4rem;
    border: 1px solid white;
    font-size: 92%;
    position: relative;
  }
  .row > div {
    padding: .15rem 0.4rem;
  }
  .row::after, .row::before {
    top: 100%;
    left: 0;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
  }

  .row::after {
    border-color: rgba(136, 183, 213, 0);
    border-top-color: rgb(33, 6, 68);
    border-width: 1.4rem .4rem 0 0;
  }
  .row::before {
    border-color: rgba(194, 225, 245, 0);
    border-top-color: white;
    border-width: 1.5rem .55rem 0 0;
    margin-left: -.05rem;
  }
  .with-border::after {
    content: '';
    position: absolute;
    width: 100%;
    left: 0;
    height: 0;
    border-top: 1px solid gray;
    top: -1px;
  }
}
.bg-flag, .bg-icon {
    background-color: rgb(33, 6, 68) !important;
}
.hoverPlacemark, .activePlacemark {
  background-color: #cc374f !important;
}
.bg-primary::after {
  border-top-color: $primary !important;
}
.bg-info::after {
  border-top-color: $info !important;
}
.bg-success::after {
  border-top-color: $success !important;
}
.bg-danger::after {
  border-top-color: $danger !important;
}
.bg-warning::after {
  border-top-color: $warning !important;
}
.hoverPlacemark::after, .activePlacemark::after {
  border-top-color: #cc374f !important;
}
</style>
