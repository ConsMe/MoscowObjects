<template>
  <div
    class="object-full-info shadow"
    :class="{'bg-white': !isMobileDevice}"
    :style="{width: isMobileDevice ? '100%' : '60%'}">
    <div class="row p-3 m-0 bg-white" v-if="!isMobileDevice">
      <div class="col">
        <div class="row">
          <div class="col d-flex flex-column">
            <carousel :object="object" :path="imageFolders.big" />
          </div>
          <div class="col" style="min-height: 21rem;">
            <div class="row h-100">
              <div class="col col-12">
                <p class="mt-1 mb-3">
                  Лот
                  {{ object.id }}
                  <span class="buttons">
                    <favourite-icon :object-id="object.id" class="mr-2" />
                    <button
                      class="btn btn-outline-secondary close-btn"
                      type="button"
                      @click="closeObjectFullInfo"
                    >X</button>
                  </span>
                </p>
                <p class="mb-3" v-if="object.type === 'Invest'">{{ buildingTypes[object.buildingType].full }}</p>
                <template v-else-if="object.type === 'Retail'">
                  <p class="mb-0">{{ purposesRetail[object.purposeRetail].full }}</p>
                  <p class="mb-3">{{ object.isArendator ? 'С арендатором' : 'Без арендатора' }}</p>
                  <div class="mb-2 underground" v-if="object.underground">
                    <img src="../assets/Moscow_Metro.svg" alt="M" class="d-inline-block mr-2">
                    <span class="d-inline-block">
                      {{ object.underground }}
                    </span>
                  </div>
                </template>
                <p class="mb-0">{{ object.district }}</p>
                <p class="mb-3">{{ object.address }}</p>
                <div class="row mt-4 mb-4" v-if="object.type === 'ZU'">
                  <div class="col">
                    <p class="mb-2">Земельный участок</p>
                    <p class="mb-2" v-if="object.kadastrNumberZU && object.kadastrNumberZU.length">
                      <span class="d-block" v-for="(kadastr, i) in object.kadastrNumberZU.split(',')" :key="i">
                        {{ kadastr.trim() }}
                      </span>
                    </p>
                    <p class="mb-2">{{ object.groundS }}</p>
                    <p class="mb-2">{{ object.purposeZU }}</p>
                    <p class="mb-2 text-black" v-if="object.groundPlan.is">{{ object.groundPlan.full }}</p>
                  </div>
                  <div class="col ml-3 border-left" v-if="object.kadastrNumberOKS || object.areaS || object.purposeOKS">
                    <p class="mb-2">ОКС</p>
                    <p class="mb-2" v-if="object.kadastrNumberOKS && object.kadastrNumberOKS.length">
                      <span class="d-block" v-for="(kadastr, i) in object.kadastrNumberOKS.split(',')" :key="i">
                        {{ kadastr.trim() }}
                      </span>
                    </p>
                    <p class="mb-2" v-html="object.areaS"></p>
                    <p class="mb-2">{{ object.purposeOKS }}</p>
                  </div>
                </div>
                <template v-else-if="object.type === 'Invest'">
                  <p class="mb-3" v-html="object.areaS"></p>
                  <div class="row mb-4" v-if="object.GAP || object.caprate">
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
                  <p class="mb-3" v-html="object.areaS"></p>
                  <div class="row mb-3" v-if="object.MAP || object.payback">
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
              </div>
              <div class="col">
                <div class="row h-100">
                  <div class="col align-self-end pb-2">
                    <p class="mb-0 text-black">
                      <big v-if="objectInfoVisibility[object.id].showPrice">
                        {{ object.cost }}
                        <strong>₽</strong>
                      </big>
                      <span v-else-if="objectInfoVisibility[object.id].priceMessage" class="text-dark">
                        {{ objectInfoVisibility[object.id].priceMessage }}
                      </span>
                    </p>
                  </div>
                  <div class="col align-self-end pb-2 text-right">
                    <a href="#" @click.prevent="showObjectAtMap">посмотреть на карте</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr />
        <div class="row">
          <div class="col"
            v-if="objectInfoVisibility[object.id].fullInfo && description"
            style="white-space: pre-line">
            {{ description }}
          </div>
          <div class="col text-center mt-5" v-else-if="objectInfoVisibility[object.id].fullInfo">
            <div class="spinner-border" role="status"></div>
          </div>
          <p v-else class="font-italyc">{{ objectInfoVisibility[object.id].title }}</p>
        </div>
      </div>
    </div>
    <div class="row ml-0 mr-0 pb-3" v-else>
      <div class="col mt-4">
        <div class="row">
          <div class="col pr-3">
            <carousel :object="object" :path="imageFolders.big" />
          </div>
          <div class="col pl-3 d-flex flex-column">
            <div class="row flex-grow-1">
              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    Лот
                    {{ object.id }}
                  </div>
                  <div class="col-2 pl-0 ">
                    <favourite-icon :object-id="object.id" />
                  </div>
                  <div class="col-auto">
                    <button type="button" class="close" @click="closeObjectFullInfo">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
                <p class="mb-2" v-if="object.type === 'Invest'">{{ buildingTypes[object.buildingType].full }}</p>
                <p class="mb-2">{{ object.district }}</p>
                <p class="mb-2">{{ object.address }}</p>
              </div>
            </div>
            <p class="mt-4 mb-0 text-white">
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
        <template v-if="object.type === 'ZU'">
          <div class="row mt-4 mb-2">
            <div class="col-5">Земельный участок</div>
            <div class="col">{{ object.kadastrNumberZU }}</div>
            <div class="col">{{ object.groundS }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-5">{{ object.purposeZU }}</div>
            <div class="col" v-if="object.groundPlan.is">{{ object.groundPlan.full }}</div>
          </div>
          <div class="border-top-1 mb-3"></div>
          <div class="row mt-2 mb-2">
            <div class="col-5">ОКС</div>
            <div class="col">{{ object.kadastrNumberOKS }}</div>
            <div class="col" v-html="object.areaS"></div>
          </div>
          <div class="row mb-3">
            <div class="col-5">{{ object.purposeOKS }}</div>
          </div>
        </template>
        <template v-if="object.type === 'Invest'">
          <div class="row mt-4 mb-3">
            <div class="col text-nowrap" v-html="object.areaS"></div>
            <div class="col text-nowrap text-center" v-if="object.GAP">
              {{ object.GAP }}
              <strong>₽</strong>
            </div>
            <div class="col text-nowrap text-right" v-if="object.caprate">
              {{ object.caprate + '%' }}
            </div>
          </div>
        </template>
        <div class="border-top-1 mb-3"></div>
        <div class="row">
          <div class="col"
            v-if="objectInfoVisibility[object.id].fullInfo && description"
            style="white-space: pre-line">
            {{ description }}
          </div>
          <div class="col text-center mt-5" v-else-if="objectInfoVisibility[object.id].fullInfo">
            <div class="spinner-border" role="status"></div>
          </div>
          <p v-else class="font-italyc">{{ objectInfoVisibility[object.id].title }}</p>
        </div>
      </div>
      <div class="col-12 text-right mt-3" v-if="objectInfoVisibility[object.id].fullInfo && description">
        <button
          class="btn btn-primary rounded-0"
          @click="checkForTizer"
          type="button"
          :disabled="disabled.downloadTizer"
        >Скачать тизер</button>
      </div>
    </div>
    <transition name="bounce" v-if="!isMobileDevice">
      <div class="download" v-show="show">
        <button
          class="btn btn-primary rounded-0 text-nowrap download-tizer w-100 mb-1 border border-left-0"
          @click="checkForTizer"
          type="button"
          :disabled="disabled.downloadTizer"
        >Скачать тизер</button>
        <button
          class="btn btn-secondary rounded-0 text-nowrap download-docs w-100 border border-left-0"
          v-if="object.docs && object.docs.length"
          type="button"
          @click.prevent="getdoc"
        >
          Документация
          <i class="fa fa-file-pdf-o d-block mt-3 mb-2"></i>
        </button>
      </div>
    </transition>
  </div>
</template>

<style lang="scss">
@import "../assets/css/_variables.scss";

.object-full-info {
  position: absolute;
  left: 0;
  z-index: 2;
  @media (min-width: 992px){
    & {
      color: $gray-600;
      height: 100%;
    }
    .fa-heart-o,
    .fa-heart {
      font-size: 1.9rem !important;
      cursor: pointer;
    }
    .fa-heart-o:hover {
      text-shadow: 0px 0px 1px #cc0000 !important;
    }
    p {
      line-height: 1.5rem;
    }
    .download {
      position: absolute;
      left: 100%;
      top: 2.7rem;
      display: inline-block;
      z-index: 1;

      & > button {
        border-color: white !important;
        box-shadow: 5px 5px 5px 0px rgba(0,0,0,.51);
      }
    }
    & > .row {
      position: relative;
      height: calc(100vh - 55px);
      overflow-y: auto;
      z-index: 2;
    }
  }
  @media (max-width: 991.98px){
    & {
      background: #060606;
      max-height: 100%;
      overflow-y: auto;
    }
    .close {
      margin-top: -.2rem;
      font-size: 1.7rem;
      line-height: 1rem;
    }
    .fa-heart-o,
    .fa-heart {
      margin-top: -.5rem;
      font-size: 1.5rem !important;
    }
    .border-top-1 {
      border-bottom: 1px solid $gray-500;
    }
  }
  .close-btn {
    padding: .3rem 0.8rem;
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
.object-full-info > .row::-webkit-scrollbar {
  background: transparent;
  width: 0.3rem;
}
.object-full-info > .row::-webkit-scrollbar-thumb {
  background: #888;
}
.object-full-info .buttons {
  position: absolute;
  right: 1rem;
  top: 0;
  display: flex;
  align-items: center;
}
.object-full-info .fa-file-pdf-o {
  font-size: 2rem;
}
.image-type {
  position: absolute;
  right: 0;
  bottom: 0;
  display: inline-block !important;
}
.building-name {
  position: absolute;
  right: 0;
  top: 0;
  display: inline-block !important;
}
</style>

<script>
import { mapState } from 'vuex';
import FavouriteIcon from './elements/FavouriteIcon.vue';
import Http from '../modules/Http';
import toastr from './elements/toastr';
import Carousel from './elements/Carousel.vue';
import buildingTypes from '../assets/data/buildingTypes';
import purposesRetail from '../assets/data/purposesRetail';

export default {
  name: 'ObjectFullInfo',
  components: {
    FavouriteIcon,
    Carousel,
  },
  data() {
    return {
      descriptionError: false,
      unwatch: null,
      show: false,
      disabled: {
        downloadTizer: false,
      },
      buildingTypes,
      purposesRetail,
    };
  },
  computed: {
    ...mapState({
      object: state => state.main.currentObject,
      currentCategorySlug: state => state.currentCategorySlug,
      imageFolders: state => state.imageFolders,
    }),
    description() {
      return this.$store.state.main.objectsDescriptions[this.object.id];
    },
    objectInfoVisibility() {
      return this.$store.getters['main/objectInfoVisibility'];
    },
    isMobileDevice() {
      return this.$store.getters.isMobileDevice;
    },
  },
  mounted() {
    if (this.object.id && this.objectInfoVisibility[this.object.id].fullInfo) {
      this.getObjectDescription();
    }
    this.show = true;
  },
  watch: {
    currentCategorySlug() {
      this.$store.commit('main/toggleBlocksVisibility', {
        block: 'ObjectFullInfo',
        visible: false,
      });
    },
    object(nv) {
      if (nv.id) {
        this.getObjectDescription();
      }
    },
  },
  methods: {
    checkForTizer() {
      this.disabled.downloadTizer = true;
      const object = JSON.parse(JSON.stringify(this.object));
      object.description = this.description;
      if (object.type === 'Invest') {
        object.buildingType = { full: this.buildingTypes[object.buildingType].full };
      } else if (object.type === 'Retail') {
        object.purposeRetail = { full: this.purposesRetail[object.purposeRetail].full };
      } else if (object.type === 'ZU' && !object.groundPlan.is) {
        delete object.groundPlan.full;
      }
      Http.post('/pdf/object/check', {
        object,
      }).then(() => {
        this.downloadTizer(object);
      }).catch(() => {
        toastr.warning('Что-то пошло не так, попробуйте перегрузить страницу');
      }).finally(() => {
        this.disabled.downloadTizer = false;
      });
    },
    downloadTizer(object) {
      toastr.info('Идет подготовка файла для скачивания');
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '/pdf/object';
      const input = document.createElement('input');
      input.name = 'object';
      input.value = JSON.stringify(object);
      // console.log(object);
      // return;
      const input2 = document.createElement('input');
      input2.name = '_token';
      input2.value = document.head.querySelector('meta[name=csrf-token]').getAttribute('content');
      form.appendChild(input);
      form.appendChild(input2);
      document.body.appendChild(form);
      form.submit();
    },
    closeObjectFullInfo() {
      this.$store.commit('main/changeCurrentObject', {});
      const blocksLogs = this.$store.state.main.blocksVisibilityLogs;
      const prevBlock = blocksLogs.length > 1 ? blocksLogs[blocksLogs.length - 2] : null;
      const visibility = {
        block: prevBlock === 'ObjectsListBlock' ? 'ObjectsListBlock' : 'ObjectFullInfo',
        visible: prevBlock === 'ObjectsListBlock',
      };
      if (!prevBlock === 'ObjectsListBlock') {
        this.$store.commit('main/setObjectsListBlockScroll', 0);
      }
      this.$store.commit('main/toggleBlocksVisibility', visibility);
    },
    showObjectAtMap() {
      this.$store.commit('main/showObjectAtMap', this.object.coordinates);
    },
    getObjectDescription() {
      if (this.description) return;
      const { id } = this.object;
      Http.get(`/objects/${id}`)
        .then((response) => {
          this.$store.commit('main/addObjectsDescriptions', { id, description: response.data });
        })
        .catch(() => {
          this.descriptionError = true;
        });
    },
    getdoc() {
      Http.get(`/files/checkdocs/${this.object.id}`)
        .then(() => {
          window.location.href = `/files/getdoc/${this.object.id}`;
        })
        .catch(() => {
          toastr.warning('Документация не найдена, возможно она была уже удалена');
        });
    },
  },
};
</script>
