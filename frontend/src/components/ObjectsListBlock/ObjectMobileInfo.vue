<template>
  <div class="col object-mobile-info-block"
    :class="{'pb-1': type === 'list', 'mt-4': ['info', 'fullInfo'].includes(type)}">
    <div class="row">
      <div class="col pr-3">
        <span
          class="position-relative d-inline-block overflow-hidden"
          v-if="['info', 'list'].includes(type)">
          <img
            :src="imageFolders.small + object.images[0].filename"
            alt="Фото"
            class="img-fluid" />
          <span
            class="bg-primary text-white pr-3 pl-3 pt-1 pb-1 image-type"
            v-if="['ZU', 'Retail'].includes(object.type) && object.images[0].caption"
          >
            <big>{{ object.images[0].caption }}</big>
          </span>
          <span
            class="bg-danger text-white pr-3 pl-3 pt-1 pb-1 building-name-bottom text-uppercase"
            v-else-if="object.type === 'Invest'"
          >
            <big>{{ object.buildingName }}</big>
          </span>
        </span>
        <carousel
          :object="object"
          :path="imageFolders.big"
          @image-loaded="$emit('image-loaded')"
          @fancy-opened="isFancyOpened = true"
          @fancy-closed="isFancyOpened = false"
          v-else-if="type === 'fullInfo'" />
      </div>
      <div class="col pl-3 d-flex flex-column">
        <div class="row flex-grow-1">
          <div class="col" style="margin-top: -.2rem;">
            <div class="row mb-1">
              <div class="col">
                Лот
                {{ object.id }}
              </div>
              <div
                class="pl-0"
                :class="{'col-auto': type === 'list', 'col-2' : ['info', 'fullInfo'].includes(type)}">
                <favourite-icon
                  :object-id="object.id"
                  class="mt-0 position-absolute"
                  style="top: .2rem"
                  :style="{right: type === 'list' ? '1.2rem' : '60%'}" />
              </div>
              <div
                class="col-auto"
                v-if="['info', 'fullInfo'].includes(type)"
                :class="{invisible: isFancyOpened}">
                <i class="icon-close" @click="$emit('close-object-block')"></i>
              </div>
            </div>
            <p class="mb-0 l-height-normal">{{ object.district }}</p>
            <p class="mb-2 l-height-normal">{{ object.address }}</p>
            <template v-if="object.type === 'Retail'">
              <div class="mb-2 underground" v-if="object.underground">
                <img src="../../assets/Moscow_Metro.svg" alt="M" class="d-inline-block mr-2">
                <span class="d-inline-block">
                  {{ object.underground }}
                </span>
              </div>
              <p class="mb-2 text-white" v-html="object.areaS"></p>
              <div class="row mb-1" v-if="object.MAP || object.payback">
                <div class="col-auto pr-0">
                  <p class="mb-0 l-height-normal" v-if="object.MAP">МАП</p>
                  <p class="mb-0 l-height-normal" v-if="object.payback">Окупаемость</p>
                </div>
                <div class="col">
                  <p class="mb-0 l-height-normal" v-if="object.MAP">
                    {{ object.MAP }}
                    <strong>₽</strong>
                  </p>
                  <p class="mb-0 l-height-normal" v-if="object.payback">
                    {{ object.payback + ' лет' }}
                  </p>
                </div>
              </div>
            </template>
            <template v-else-if="object.type === 'Invest'">
              <p class="mb-2 text-white" v-html="object.areaS"></p>
              <div class="row mb-1" v-if="object.GAP || object.caprate">
                <div class="col-auto pr-0">
                  <p class="mb-0 l-height-normal" v-if="object.GAP">ГАП</p>
                  <p class="mb-0 l-height-normal" v-if="object.caprate">Caprate</p>
                </div>
                <div class="col">
                  <p class="mb-0 l-height-normal" v-if="object.GAP">
                    {{ object.GAP }}
                    <strong>₽</strong>
                  </p>
                  <p class="mb-0 l-height-normal" v-if="object.caprate">
                    {{ object.caprate + '%' }}
                  </p>
                </div>
              </div>
            </template>
          </div>
        </div>
        <object-price
          :object="object"
          :isMobileDevice="isMobileDevice"
          v-if="object.type === 'ZU'" class="mt-4" />
      </div>
    </div>
    <div class="row mt-2 mb-3" v-if="['Invest', 'Retail'].includes(object.type)">
      <div class="col text-right pr-3 align-self-center" v-if="object.type === 'Invest'">
        {{ buildingTypes[object.buildingType].mobileFull || buildingTypes[object.buildingType].full }}
      </div>
      <div class="col text-right pr-3 align-self-center" v-else-if="object.type === 'Retail'">
        {{ purposesRetail[object.purposeRetail].full }}
      </div>
      <div class="col pl-3">
        <object-price :object="object" :isMobileDevice="isMobileDevice" />
      </div>
    </div>
    <template v-else-if="object.type === 'ZU'">
      <div class="row mt-4 mb-3" v-if="type === 'list'">
        <div class="col-1">{{ object.ZUType }}</div>
        <div class="col text-nowrap">{{ object.groundS }}</div>
        <div class="col text-nowrap" v-html="object.areaS"></div>
        <div class="col">{{ getZUpurpose(object) }}</div>
        <div class="col text-white">
          {{ object.groundPlan.is ? object.groundPlan.mobile : '' }}
        </div>
      </div>
      <template v-else-if="['info', 'fullInfo'].includes(type)">
        <div class="row mt-4 mb-0">
          <div class="col-4 pr-0">Земельный участок</div>
          <div class="col">{{ object.kadastrNumberZU }}</div>
          <div class="col">{{ object.groundS }}</div>
        </div>
        <div class="row mb-2">
          <div class="col-4">{{ object.purposeZU }}</div>
          <div class="col text-white" v-if="object.groundPlan.is">{{ object.groundPlan.full }}</div>
        </div>
        <div class="border-top-1 mb-0"></div>
        <div class="row mt-2 mb-0">
          <div class="col-4">ОКС</div>
          <div class="col">{{ object.kadastrNumberOKS }}</div>
          <div class="col" v-html="object.areaS"></div>
        </div>
        <div class="row mb-2">
          <div class="col-4">{{ object.purposeOKS }}</div>
        </div>
      </template>
    </template>
    <div class="border-top-1" v-if="type === 'list'"></div>
    <template v-if="type === 'fullInfo'">
      <div class="border-top-1 mb-1"></div>
      <div class="row">
        <div class="col"
          v-if="visibility.fullInfo && description"
          style="white-space: pre-line">
          {{ description }}
        </div>
        <div class="col text-center mt-5" v-else-if="visibility.fullInfo">
          <div class="spinner-border" role="status"></div>
        </div>
        <p v-else class="font-italyc">{{ visibility.title }}</p>
      </div>
    </template>
  </div>
</template>

<style lang="scss">
@import "../../assets/css/_variables.scss";

.object-mobile-info-block {
  .icon-close {
    position: absolute;
    right: 1rem;
    top: 0.2rem;
    font-size: 1.4rem;
    color: $gray-300;
  }
}
</style>

<script>
import { mapState } from 'vuex';
import buildingTypes from '../../assets/data/buildingTypes';
import purposesRetail from '../../assets/data/purposesRetail';
import ObjectPrice from './ObjectMobilePrice.vue';
import FavouriteIcon from '../elements/FavouriteIcon.vue';
import Carousel from '../elements/Carousel.vue';

export default {
  name: 'ObjectMobileInfo',
  props: ['object', 'isMobileDevice', 'type', 'description', 'visibility'],
  components: {
    ObjectPrice, FavouriteIcon, Carousel,
  },
  data() {
    return {
      buildingTypes,
      purposesRetail,
      isFancyOpened: false,
    };
  },
  computed: {
    ...mapState([
      'imageFolders',
    ]),
  },
  methods: {
    getZUpurpose(object) {
      let purpose = object.ZUType === 'ЗУ' ? object.purposeZU : object.purposeOKS;
      if (this.isMobileDevice && purpose === 'Апартаменты') {
        purpose = 'Апарт.';
      }
      return purpose;
    },
  },
};
</script>
