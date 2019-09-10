<template>
  <div class="objects-list-block shadow" ref="objectsListBlock" :style="{maxWidth: '60%'}">
    <div class="row m-0 pb-0">
      <div class="col p-0 pb-1">
        <table class="table table-hover m-0 sticky-thead">
          <thead>
            <tr>
              <th scope="col">{{ currentCategorySlug === 'ZU' ? '' : 'Название' }}</th>
              <th scope="col">Лот</th>
              <th scope="col">Субъект</th>
              <th scope="col">Адрес</th>
              <template v-if="currentCategorySlug === 'ZU'">
                <th scope="col">Тип</th>
                <th scope="col">S ЗУ</th>
                <th scope="col">S ОКС</th>
                <th scope="col">Назначение</th>
                <th scope="col">ГПЗУ</th>
              </template>
              <template v-if="currentCategorySlug === 'Invest'">
                <th scope="col">Тип</th>
                <th scope="col">S</th>
                <th scope="col">ГАП, Р.</th>
                <th scope="col">Caprate</th>
              </template>
              <th scope="col" class="text-right">Стоимость, Р.</th>
            </tr>
          </thead>
          <tbody>
            <tr
              class="bg-white"
              v-for="object in objects"
              :key="object.id"
              @click="showObjectFullInfo(object)"
              :title="objectInfoVisibility[object.id].title"
            >
              <td width="25%">
                <span class="position-relative d-inline-block">
                  <img :src="imageFolders.small + object.images[0].filename" alt="Фото" class="img-fluid" />
                  <span
                    class="bg-primary text-white pr-2 pl-2 pt-1 pb-1 image-type"
                    v-if="currentCategorySlug === 'ZU'"
                  >
                    <small>{{ object.images[0].caption }}</small>
                  </span>
                  <span
                    class="bg-danger text-white pr-2 pl-2 pt-1 pb-1 building-name text-uppercase"
                    v-else-if="currentCategorySlug === 'Invest'"
                  >
                    <small>{{ object.buildingName }}</small>
                  </span>
                </span>
              </td>
              <td class="align-middle">{{ object.id }}</td>
              <td class="align-middle">{{ object.district }}</td>
              <td class="align-middle">{{ object.address }}</td>
              <template v-if="currentCategorySlug === 'ZU'">
                <td class="align-middle text-nowrap">{{ object.ZUType }}</td>
                <td class="align-middle text-nowrap">{{ object.groundS }}</td>
                <td class="align-middle text-nowrap" v-html="object.areaS"></td>
                <td class="align-middle">
                  {{ object.ZUType === 'ZU' ? object.purposeZU : object.purposeOKS }}
                </td>
                <td class="align-middle">{{ object.groundPlan ? 'Есть' : 'Нет' }}</td>
              </template>
              <template v-if="currentCategorySlug === 'Invest'">
                <td class="align-middle">{{ object.buildingType.short }}</td>
                <td class="align-middle text-nowrap" v-html="object.areaS"></td>
                <td class="align-middle text-nowrap">{{ object.GAP }}</td>
                <td class="align-middle">{{ object.caprate + '%' }}</td>
              </template>
              <td class="text-right align-middle position-relative text-nowrap">
                <span v-if="objectInfoVisibility[object.id].showPrice">{{ object.cost }}</span>
                <favourite-icon :object-id="object.id" />
                <a href class="showInMap" @click.stop.prevent="showObjectAtMap(object)">на карте</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <transition name="bounce">
      <span class="download-list" v-show="show">
        <button
          class="btn btn-primary rounded-0 shadow border border-left-0"
          type="button"
          @click="downloadPdf">
          Скачать список
        </button>
      </span>
    </transition>
  </div>
</template>

<style lang="scss">
.objects-list-block {
  position: absolute;
  left: 0;
  width: auto;
  z-index: 2;
  background: #060606;
  max-height: 100%;
  display: flex;
  flex-direction: column;
}
.objects-list-block > .row {
  position: relative;
  height: 100%;
  overflow-y: auto;
  z-index: 2;
  flex: 1;
}
.objects-list-block > .row::-webkit-scrollbar {
  background: transparent;
  width: 0.3rem;
}
.objects-list-block > .row::-webkit-scrollbar-thumb {
  background: #888;
}
.objects-list-block {
  .fa-heart-o,
  .fa-heart {
    font-size: 1.5rem !important;
    position: absolute;
    right: 0.5rem;
    top: 0.5rem !important;
    cursor: pointer;
  }
  .fa-heart-o:hover {
    text-shadow: 0px 0px 1px #cc0000;
  }
  .list-enter-active, .list-leave-active {
    transition: all 1s;
  }
  .list-enter, .list-leave-to /* .list-leave-active до версии 2.1.8 */ {
    opacity: 0;
  }
}
.showInMap {
  position: absolute;
  right: 0.5rem;
  bottom: 0.5rem;
}
.objects-list-block .bg-white {
  cursor: pointer;
}
.objects-list-block .bg-white:hover {
  background-color: #ededed !important;
}
.sticky-thead tr > th {
  background-color: #060606;
  white-space: nowrap;
  font-weight: normal !important;
  color: white;
  position: sticky;
  top: -1px;
  z-index: 3;
}
.download-list {
  position: absolute;
  left: 100%;
  top: 2.7rem;
  display: table;
  z-index: 1;
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
import toastr from './elements/toastr';
import Http from '../modules/Http';

export default {
  name: 'ObjectsListBlock',
  components: {
    FavouriteIcon,
  },
  data() {
    return {
      show: false,
    };
  },
  computed: {
    objects() {
      return this.$store.getters['main/objects'];
    },
    filterWidth() {
      return this.$store.state.filterWidth;
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
    this.show = true;
  },
  methods: {
    showObjectFullInfo(object) {
      if (!this.objectInfoVisibility[object.id].fullInfo) {
        toastr.info(this.objectInfoVisibility[object.id].title);
        return;
      }
      this.$store.commit('main/changeCurrentObject', object);
      this.$store.commit('main/toggleBlocksVisibility', {
        block: 'ObjectFullInfo',
        visible: true,
      });
    },
    showObjectAtMap(object) {
      this.$store.commit('main/changeCurrentObject', object);
      this.$store.commit('main/showObjectAtMap', object.coordinates);
    },
    downloadPdf() {
    //   Http.post('pdf/list', { objects: this.objects })
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = 'pdf/list';
      const input = document.createElement('input');
      input.name = 'objects';
      input.value = JSON.stringify(this.objects);
      const input2 = document.createElement('input');
      input2.name = '_token';
      input2.value = document.head.querySelector('meta[name=csrf-token]').getAttribute('content');
      const input3 = document.createElement('input');
      input3.name = 'currentCategorySlug';
      input3.value = this.currentCategorySlug;
      form.appendChild(input);
      form.appendChild(input2);
      form.appendChild(input3);
      document.body.appendChild(form);
      form.submit();
    },
  },
};
</script>
