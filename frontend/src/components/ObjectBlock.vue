<template>
    <div class="object-block" ref="objectblock">
        <div class="row ml-0 mr-0 pb-3">
            <div class="col">
                <p class="pt-3 pb-3">
                    <button type="button" class="close" @click="closeObjectBlock">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </p>
                <span class="position-relative d-inline-block">
                    <img :src="imageFolders.big + object.images[0].filename" alt="Фото" class="img-fluid" />
                    <span
                        class="bg-primary text-white pr-3 pl-3 pt-1 pb-1 image-type"
                        v-if="object.type === 'ZU'"
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
                <p class="mt-3 mb-2">
                    Лот
                    {{ object.id }}
                    <favourite-icon :object-id="object.id" class="float-right" />
                </p>
                <p
                    class="mb-2"
                    v-if="object.type === 'Invest'"
                >{{ object.buildingType.full }}</p>
                <p class="mb-2">{{ object.district }}</p>
                <p class="mb-2">{{ object.address }}</p>
                <div class="row mt-4" v-if="object.type === 'ZU'">
                    <div class="col border-right">
                        <p class="mb-2">Земельный участок</p>
                        <p class="mb-2">{{ object.kadastrNumberZU }}</p>
                        <p class="mb-2">{{ object.groundS }}</p>
                        <p class="mb-2">{{ object.purposeZU }}</p>
                        <p class="mb-0" v-if="object.groundPlan">ГПЗУ</p>
                    </div>
                    <div class="col">
                        <p class="mb-2">ОКС</p>
                        <p class="mb-2">{{ object.kadastrNumberOKS }}</p>
                        <p class="mb-2" v-html="object.areaS"></p>
                        <p class="mb-2">{{ object.purposeOKS }}</p>
                    </div>
                </div>
                <template v-if="object.type === 'Invest'">
                    <p class="mb-2" v-html="object.areaS"></p>
                    <p class="mb-2">{{ object.groundS }}</p>
                    <p class="mb-2">
                        {{ object.GAP }}
                        <strong>Р</strong>
                    </p>
                    <p class="mb-2">{{ object.caprate + '%' }}</p>
                </template>
                <p class="mt-4 mb-3 text-white">
                    <big v-if="objectInfoVisibility[object.id].showPrice">
                        {{ object.cost }}
                        <strong>Р</strong>
                    </big>
                    <span v-else-if="objectInfoVisibility[object.id].priceMessage" class="text-dark">
                      {{ objectInfoVisibility[object.id].priceMessage }}
                    </span>
                </p>
            </div>
        </div>
        <button
          class="btn btn-block btn-primary text-uppercase rounded-0 btn-lg justify-content-center"
          @click="showObjectFullInfo"
          :title="objectInfoVisibility[object.id].title">
          <i class="fa fa-lock mr-2" v-if="objectInfoVisibility[object.id].lock"></i>
          Подробнее
        </button>
    </div>
</template>

<style lang="scss">
.object-block {
    position: absolute;
    left: 0;
    width: 0;
    z-index: 2;
    background: #060606;
    height: 100%;
    display: flex;
    flex-direction: column;
    .fa-lock {
      line-height: unset;
      opacity: .8;
    }
}
.object-block > .row {
    flex: 1;
    overflow-y: auto;
}
.object-block > .row::-webkit-scrollbar {
    background: transparent;
    width: .3rem;
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
.object-block {
    .fa-heart-o, .fa-heart {
        font-size: 1.5rem !important;
        cursor: pointer;
    }
    .fa-heart-o:hover {
        text-shadow: 0px 0px 1px #cc0000;
    }
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

export default {
  name: 'ObjectBlock',
  components: {
    FavouriteIcon,
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
        toastr.info(this.objectInfoVisibility[this.object.id].title);
        return;
      }
      this.$store.commit('main/toggleBlocksVisibility', {
        block: 'ObjectFullInfo',
        visible: true,
      });
    },
  },
};
</script>
