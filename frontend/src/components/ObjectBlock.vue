<template>
  <div
    class="object-block shadow"
    ref="objectblock"
    :style="{width: objectBlockWidth ? `${objectBlockWidth}px` : '100%'}"
  >
    <div class="row ml-0 mr-0 pb-3" v-if="!isMobileDevice">
      <div class="col">
        <p class="pt-3 pb-3">
          <button type="button" class="close" @click="closeObjectBlock">
            <span aria-hidden="true">&times;</span>
          </button>
        </p>
        <span class="position-relative d-inline-block overflow-hidden">
          <img :src="imageFolders.big + object.images[0].filename" alt="Фото" class="img-fluid" />
          <span
            class="bg-primary text-white pr-3 pl-3 pt-1 pb-1 image-type"
            v-if="object.type === 'ZU' && object.images[0].caption"
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
        <p class="mt-3 mb-3">
          Лот
          {{ object.id }}
          <favourite-icon :object-id="object.id" class="float-right" />
        </p>
        <p class="mb-3" v-if="object.type === 'Invest'">{{ buildingTypes[object.buildingType].full }}</p>
        <template v-else-if="object.type === 'Retail'">
          <p class="mb-0">{{ purposesRetail[object.purposeRetail].full }}</p>
          <p class="mb-3">{{ object.isArendator ? 'С арендатором' : 'Без арендатора' }}</p>
          <div class="mb-3 underground" v-if="object.underground">
            <img src="../assets/Moscow_Metro.svg" alt="M" class="d-inline-block mr-2">
            <span class="d-inline-block">
              {{ object.underground }}
            </span>
          </div>
        </template>
        <p class="mb-0">{{ object.district }}</p>
        <p class="mb-3">{{ object.address }}</p>
        <div class="row mt-4" v-if="object.type === 'ZU'">
          <div class="col">
            <p class="mb-2">Земельный участок</p>
            <p class="mb-2">{{ object.kadastrNumberZU }}</p>
            <p class="mb-2">{{ object.groundS }}</p>
            <p class="mb-2">{{ object.purposeZU }}</p>
            <p class="mb-0 text-white" v-if="object.groundPlan.is">{{ object.groundPlan.full }}</p>
          </div>
          <div class="col border-left" v-if="object.kadastrNumberOKS || object.areaS || object.purposeOKS">
            <p class="mb-2">ОКС</p>
            <p class="mb-2">{{ object.kadastrNumberOKS }}</p>
            <p class="mb-2" v-html="object.areaS"></p>
            <p class="mb-2">{{ object.purposeOKS }}</p>
          </div>
        </div>
        <template v-else-if="object.type === 'Invest'">
          <p class="mb-3 text-white" v-html="object.areaS"></p>
          <div class="row mb-2" v-if="object.GAP || object.caprate">
            <div class="col-auto pr-0">
              <p class="mb-0" v-if="object.GAP">ГАП</p>
              <p class="mb-0" v-if="object.caprate">Caprate</p>
            </div>
            <div class="col">
              <p class="mb-0" v-if="object.GAP">
                {{ object.GAP }}
                <strong>₽</strong>
              </p>
              <p class="mb-0" v-if="object.caprate">
                {{ object.caprate + '%' }}
              </p>
            </div>
          </div>
        </template>
        <template v-else-if="object.type === 'Retail'">
          <p class="mb-3 text-white" v-html="object.areaS"></p>
          <div class="row mb-2" v-if="object.MAP || object.payback">
            <div class="col-auto pr-0">
              <p class="mb-0" v-if="object.MAP">МАП</p>
              <p class="mb-0" v-if="object.payback">Окупаемость</p>
            </div>
            <div class="col">
              <p class="mb-0" v-if="object.MAP">
                {{ object.MAP }}
                <strong>₽</strong>
              </p>
              <p class="mb-0" v-if="object.payback">
                {{ object.payback + ' лет' }}
              </p>
            </div>
          </div>
        </template>
        <p class="mt-4 mb-3 text-white">
          <big v-if="objectInfoVisibility[object.id].showPrice">
            {{ object.cost }}
            <strong>₽</strong>
          </big>
          <span
            v-else-if="objectInfoVisibility[object.id].priceMessage"
            class="text-dark"
          >{{ objectInfoVisibility[object.id].priceMessage }}</span>
        </p>
      </div>
    </div>
    <div class="row ml-0 mr-0 pb-3" v-else>
      <object-info
        :object="object"
        :isMobileDevice="isMobileDevice"
        type="info"
        @close-object-block="closeObjectBlock" />
    </div>
    <button
      class="btn btn-block btn-primary text-uppercase rounded-0 btn-lg justify-content-center"
      @click="showObjectFullInfo"
      :title="objectInfoVisibility[object.id].title"
    >
      <i class="fa fa-lock mr-2" v-if="objectInfoVisibility[object.id].lock"></i>
      Подробнее
    </button>
  </div>
</template>

<style lang="scss">
@import "../assets/css/_variables.scss";

.object-block {
  position: absolute;
  left: 0;
  width: 0;
  z-index: 2;
  background: #060606;
  display: flex;
  flex-direction: column;
  .fa-lock {
    line-height: unset;
    opacity: 0.8;
  }
  .close {
    font-size: 1.7rem;
    line-height: 1rem;
  }
  .fa-heart-o,
  .fa-heart {
    font-size: 1.5rem !important;
    cursor: pointer;
  }
  .fa-heart-o:hover {
    text-shadow: 0px 0px 1px #cc0000;
  }
  @media (min-width: 992px){
    height: 100%;
    & > .row {
      flex: 1;
      overflow-y: auto;
    }
  }
  @media (max-width: 991.98px){
    .close {
      margin-top: -.2rem;
    }
    .fa-heart-o,
    .fa-heart {
      margin-top: -.5rem;
      max-height: 100%;
    }
    & {
      max-height: 100%;
      overflow-y: auto;
    }
  }
  .border-top-1 {
    border-bottom: 1px solid $gray-500;
  }
  .underground {
    img {
      height: 1rem;
    }
    * {
      vertical-align: middle;
    }
  }
}
.object-block > .row::-webkit-scrollbar {
  background: transparent;
  width: 0.3rem;
}
.object-block > .row::-webkit-scrollbar-thumb {
  background: #888;
}
.object-block > button {
  align-self: end;
  display: flex;
  flex-direction: row;
}
input[type="text"] {
  border-bottom: 1px solid #888;
}
.image-type,
.building-name-bottom {
  position: absolute;
  right: 0;
  bottom: 0;
  display: inline-block !important;
}
</style>

<script>
import FavouriteIcon from './elements/FavouriteIcon.vue';
import toastr from './elements/toastr';
import buildingTypes from '../assets/data/buildingTypes';
import purposesRetail from '../assets/data/purposesRetail';
import ObjectInfo from './ObjectsListBlock/ObjectMobileInfo.vue';

export default {
  name: 'ObjectBlock',
  components: {
    FavouriteIcon, ObjectInfo,
  },
  data() {
    return { buildingTypes, purposesRetail };
  },
  computed: {
    objectBlockWidth() {
      return this.$store.state.objectBlockWidth;
    },
    object() {
      return this.$store.state.main.currentObject;
    },
    currentCategorySlug() {
      return this.$store.state.currentCategorySlug;
    },
    imageFolders() {
      return this.$store.state.imageFolders;
    },
    objectInfoVisibility() {
      return this.$store.getters['main/objectInfoVisibility'];
    },
    isMobileDevice() {
      return this.$store.getters.isMobileDevice;
    },
  },
  mounted() {
    this.$refs.objectblock.style.width = `${this.objectBlockWidth}px`;
  },
  watch: {
    objectBlockWidth(nv) {
      this.$refs.objectblock.style.width = `${nv}px`;
    },
    currentCategorySlug() {
      this.$store.commit('main/toggleBlocksVisibility', {
        block: 'ObjectBlock',
        visible: false,
      });
    },
  },
  methods: {
    closeObjectBlock() {
      this.$store.commit('main/changeCurrentObject', {});
      this.$store.commit('main/toggleBlocksVisibility', {
        block: 'ObjectBlock',
        visible: false,
      });
    },
    showObjectFullInfo() {
      if (!this.objectInfoVisibility[this.object.id].fullInfo) {
        toastr.info(this.objectInfoVisibility[this.object.id].title, null, {
          containerId: 'toast-container2',
          positionClass: 'toast-bottom-left',
          onclick: () => {
            this.$router.push({ name: 'lk-login' });
          },
        });
        return;
      }
      this.$router.push({ name: this.currentCategorySlug, params: { objectId: this.object.id.toString() } });
    },
  },
};
</script>
