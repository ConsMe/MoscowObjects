<template>
  <div class="object-full-info bg-white shadow" :style="{maxWidth: '60%'}">
    <div class="row p-3 m-0 bg-white">
      <div class="col">
        <div class="row">
          <div class="col">
            <img :src="imageFolders.big + object.images[0].filename" alt="Фото" class="img-fluid" />
          </div>
          <div class="col">
            <div class="row h-100">
              <div class="col col-12">
                <p class="mt-1 mb-2">
                  Лот
                  {{ object.id }}
                  <span class="buttons">
                    <favourite-icon :object-id="object.id" class="mr-2" />
                    <button
                      class="btn btn-outline-secondary"
                      type="button"
                      @click="closeObjectFullInfo"
                    >X</button>
                  </span>
                </p>
                <p class="mb-2" v-if="object.type === 'Invest'">{{ object.buildingType.full }}</p>
                <p class="mb-2">{{ object.district }}</p>
                <p class="mb-2">{{ object.address }}</p>
                <div class="row mt-4 mb-4" v-if="object.type === 'ZU'">
                  <div class="col border-right">
                    <p class="mb-2">Земельный участок</p>
                    <p class="mb-2">{{ object.kadastrNumberZU }}</p>
                    <p class="mb-2">{{ object.groundS }}</p>
                    <p class="mb-2">{{ object.purposeZU }}</p>
                    <p class="mb-2" v-if="object.groundPlanOKS">ГПЗУ</p>
                  </div>
                  <div class="col ml-3">
                    <p class="mb-2">ОКС</p>
                    <p class="mb-2">{{ object.kadastrNumberOKS }}</p>
                    <p class="mb-2" v-html="object.areaS"></p>
                    <p class="mb-2">{{ object.purposeOKS }}</p>
                  </div>
                </div>
                <template v-if="object.type === 'Invest'">
                  <p class="mb-2" v-html="object.areaS"></p>
                  <p class="mb-2" v-html="object.groundS"></p>
                  <p class="mb-2">
                    ГАП
                    {{ object.GAP }}
                    <strong>Р</strong>
                  </p>
                  <p class="mb-2 mb-4">Caprate {{ object.caprate + '%' }}</p>
                </template>
              </div>
              <div class="col">
                <div class="row h-100">
                  <div class="col align-self-end pb-2">
                    <p class="mb-0">
                      <big v-if="objectInfoVisibility[object.id].showPrice">
                        {{ object.cost }}
                        <strong>Р</strong>
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
    <transition name="bounce">
      <div class="download" v-show="show">
        <button
          class="btn btn-primary rounded-0 text-nowrap download-tizer w-100 mb-1 shadow border border-left-0"
          @click="downloadTizer"
        >Скачать тизер</button>
        <button
          class="btn btn-secondary rounded-0 text-nowrap download-docs w-100 shadow border border-left-0"
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
.object-full-info {
  position: absolute;
  left: 0;
  width: auto;
  z-index: 2;
  height: 100%;
}
.object-full-info > .row {
  position: relative;
  height: calc(100vh - 55px);
  overflow-y: auto;
  z-index: 2;
}
.object-full-info > .row::-webkit-scrollbar {
  background: transparent;
  width: 0.3rem;
}
.object-full-info > .row::-webkit-scrollbar-thumb {
  background: #888;
}
.object-full-info {
  .fa-heart-o,
  .fa-heart {
    font-size: 1.9rem !important;
    cursor: pointer;
  }
  .fa-heart-o:hover {
    text-shadow: 0px 0px 1px #cc0000 !important;
  }
}
.object-full-info .buttons {
  position: absolute;
  right: 1rem;
  top: 0;
  display: flex;
  align-items: center;
}
.object-full-info p {
  line-height: 1.7rem;
}
.object-full-info .download {
  position: absolute;
  left: 100%;
  top: 2.7rem;
  display: inline-block;
  z-index: 1;
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
import FavouriteIcon from './elements/FavouriteIcon.vue';
import ObjectFullInfoPdf from '../pdf/ObjectFullInfoPdf';
import Http from '../modules/Http';
import toastr from './elements/toastr';

export default {
  name: 'ObjectFullInfo',
  components: {
    FavouriteIcon,
  },
  data() {
    return {
      descriptionError: false,
      unwatch: null,
      show: false,
    };
  },
  computed: {
    object() {
      return this.$store.state.main.currentObject;
    },
    currentCategorySlug() {
      return this.$store.state.currentCategorySlug;
    },
    description() {
      return this.$store.state.main.objectsDescriptions[this.object.id];
    },
    imageFolders() {
      return this.$store.state.imageFolders;
    },
    objectInfoVisibility() {
      return this.$store.getters['main/objectInfoVisibility'];
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
    downloadTizer() {
      ObjectFullInfoPdf();
    },
    closeObjectFullInfo() {
      this.$store.commit('main/changeCurrentObject', {});
      this.$store.commit('main/toggleBlocksVisibility', {
        block: 'ObjectFullInfo',
        visible: false,
      });
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
