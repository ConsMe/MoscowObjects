<template>
  <div class="objects-list-block shadow" ref="objectsListBlock" :style="{width: isMobileDevice ? '100%' : '60%'}">
    <div class="row m-0 pb-0" v-if="!isMobileDevice">
      <div class="col p-0 pb-1">
        <table class="table table-hover m-0 sticky-thead">
          <thead>
            <tr>
              <th scope="col" :class="[sort.buildingName ? `sort-${sort.buildingName}` : null]" @click="sortTo('buildingName')">{{ currentCategorySlug === 'ZU' ? '' : 'Название' }}</th>
              <th scope="col" :class="[sort.id ? `sort-${sort.id}` : null]" @click="sortTo('id')">Лот</th>
              <th scope="col" :class="[sort.district ? `sort-${sort.district}` : null]" @click="sortTo('district')">Субъект</th>
              <th scope="col" :class="[sort.address ? `sort-${sort.address}` : null]" @click="sortTo('address')">Адрес</th>
              <template v-if="currentCategorySlug === 'ZU'">
                <th scope="col" :class="[sort.ZUType ? `sort-${sort.ZUType}` : null]" @click="sortTo('ZUType')">Тип</th>
                <th scope="col" :class="[sort.groundS ? `sort-${sort.groundS}` : null]" @click="sortTo('groundS')">S ЗУ</th>
                <th scope="col" :class="[sort.areaS ? `sort-${sort.areaS}` : null]" @click="sortTo('areaS')">S ОКС</th>
                <th scope="col" :class="[sort.purpose ? `sort-${sort.purpose}` : null]" @click="sortTo('purpose')">Назначение</th>
                <th scope="col" :class="[sort.groundPlan ? `sort-${sort.groundPlan}` : null]" @click="sortTo('groundPlan')">ГПЗУ</th>
              </template>
              <template v-if="currentCategorySlug === 'Invest'">
                <th scope="col" :class="[sort.type ? `sort-${sort.type}` : null]" @click="sortTo('type')">Тип</th>
                <th scope="col" :class="[sort.areaS ? `sort-${sort.areaS}` : null]" @click="sortTo('areaS')">S</th>
                <th scope="col" :class="[sort.GAP ? `sort-${sort.GAP}` : null]" @click="sortTo('GAP')">ГАП, Р.</th>
                <th scope="col" :class="[sort.caprate ? `sort-${sort.caprate}` : null]" @click="sortTo('caprate')">Caprate</th>
              </template>
              <th scope="col" class="text-right" :class="[sort.cost ? `sort-${sort.cost}` : null]" @click="sortTo('cost')">Стоимость, Р.</th>
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
                    v-if="currentCategorySlug === 'ZU' && object.images[0].caption"
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
                  {{ object.ZUType === 'ЗУ' ? object.purposeZU : object.purposeOKS }}
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
                <div class="position-absolute d-inline-block w-100 h-100 link-wrap">
                  <a href class="showInMap d-inline-block" @click.stop.prevent="showObjectAtMap(object)">на карте</a>
                </div>
                <span v-if="objectInfoVisibility[object.id].showPrice">{{ object.cost }}</span>
                <favourite-icon :object-id="object.id" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <template v-else>
      <div
        class="row m-0 mt-4 pb-0"
        v-for="object in objects"
        :key="object.id"
        @click="showObjectFullInfo(object)">
        <div class="col pb-1">
          <div class="row">
            <div class="col pr-3">
              <span class="position-relative d-inline-block">
                <img :src="imageFolders.small + object.images[0].filename" alt="Фото" class="img-fluid" />
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
            </div>
            <div class="col pl-3 d-flex flex-column">
              <div class="row flex-grow-1">
                <div class="col">
                  <div class="row mb-2">
                    <div class="col">
                      Лот
                      {{ object.id }}
                    </div>
                    <div class="col-auto pl-0 ">
                      <favourite-icon :object-id="object.id" />
                    </div>
                  </div>
                  <p class="mb-2" v-if="object.type === 'Invest'">{{ object.buildingType.full }}</p>
                  <p class="mb-2">{{ object.district }}</p>
                  <p class="mb-2">{{ object.address }}</p>
                </div>
              </div>
              <p class="mt-4 mb-0 text-white">
                <big v-if="objectInfoVisibility[object.id].showPrice">
                  {{ object.cost }}
                  <strong>Р</strong>
                </big>
                <span
                  v-else-if="objectInfoVisibility[object.id].priceMessage"
                  class="text-dark"
                >{{ objectInfoVisibility[object.id].priceMessage }}</span>
              </p>
            </div>
          </div>
          <div class="row mt-4 mb-3">
            <template v-if="object.type === 'ZU'">
              <div class="col-auto">{{ object.ZUType }}</div>
              <div class="col text-nowrap text-center">{{ object.groundS }}</div>
              <div class="col text-nowrap text-center" v-html="object.areaS"></div>
              <div class="col text-center">{{ object.ZUType === 'ЗУ' ? object.purposeZU : object.purposeOKS }}</div>
              <div class="col-auto text-right">{{ object.groundPlan ? 'ГПЗУ' : '' }}</div>
            </template>
            <template v-if="object.type === 'Invest'">
              <div class="col text-nowrap" v-html="object.areaS"></div>
              <div class="col text-nowrap text-center">{{ object.groundS }}</div>
              <div class="col text-nowrap text-center">
                {{ object.GAP }}
                <strong>Р</strong>
              </div>
              <div class="col text-nowrap text-right">{{ object.caprate + '%' }}</div>
            </template>
          </div>
          <div class="border-top-1"></div>
        </div>
      </div>
    </template>
    <transition name="bounce" v-if="!isMobileDevice">
      <span class="download-list" v-show="show">
        <button
          class="btn btn-primary rounded-0 shadow border border-left-0"
          :disabled="disabled.downloadPdf"
          type="button"
          @click="checkForPdf">
          Скачать список
        </button>
      </span>
    </transition>
  </div>
</template>

<style lang="scss">
@import "../assets/css/_variables.scss";

.objects-list-block {
  position: absolute;
  left: 0;
  z-index: 2;
  background: #060606;
  max-height: 100%;
  display: flex;
  flex-direction: column;

  @media (max-width: 991.98px){
    & {
      overflow-y: auto;
    }
    .fa-heart-o,
    .fa-heart {
      font-size: 1.5rem !important;
      margin-top: -.5rem;
    }
    .border-top-1 {
      border-bottom: 1px solid $gray-500;
    }
  }
  @media (min-width: 992px){
    & > .row {
      position: relative;
      height: 100%;
      overflow-y: auto;
      z-index: 2;
      flex: 1;
    }
    .link-wrap {
      left: 0;
      top: 0;
    }
    .fa-heart-o,
    .fa-heart {
      font-size: 1.5rem !important;
      position: absolute;
      right: 0.75rem;
      top: 0.5rem !important;
      cursor: pointer;
    }
  }
}
.objects-list-block > .row::-webkit-scrollbar {
  background: transparent;
  width: 0.3rem;
}
.objects-list-block > .row::-webkit-scrollbar-thumb {
  background: #888;
}
.objects-list-block {
  .fa-heart-o:hover {
    text-shadow: 0px 0px 1px #cc0000;
  }
  .list-enter-active, .list-leave-active {
    transition: all 1s;
  }
  .list-enter, .list-leave-to /* .list-leave-active до версии 2.1.8 */ {
    opacity: 0;
  }
  .sort-up::after {
    content: "↑";
    position: absolute;
    height: 100%;
    line-height: normal;
  }
  .sort-down::after {
    content: "↓";
    position: absolute;
    height: 100%;
    line-height: normal;
  }
  table, .table-hover tbody tr:hover {
    color: $gray-600;
  }
  th {
    cursor: pointer;
    position: relative;
  }
}
.showInMap {
  position: absolute;
  right: 0.75rem;
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
import { mapState } from 'vuex';
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
      disabled: {
        downloadPdf: false,
      },
      sort: { id: 'down' },
      numericFields: [
        'id', 'areaS', 'cost', 'groundS', 'GAP', 'caprate',
      ],
    };
  },
  computed: {
    objects() {
      const objects = [...this.$store.getters['main/objects']];
      const fields = Object.keys(this.sort);
      if (!fields.length) return objects;
      const field = fields[0];
      const direction = this.sort[field];
      const isFieldNumeric = this.numericFields.includes(field);
      return objects.sort((object1, object2) => {
        let a;
        let b;
        if (field === 'purpose') {
          a = object1.ZUType === 'ЗУ' ? object1.purposeZU : object1.purposeOKS;
          b = object2.ZUType === 'ЗУ' ? object2.purposeZU : object2.purposeOKS;
        } else if (field === 'type' && this.currentCategorySlug === 'Invest') {
          a = object1.buildingType.short;
          b = object2.buildingType.short;
        } else {
          a = isFieldNumeric ? parseFloat(object1[field].toString().replace(/\s/g, '')) : object1[field];
          b = isFieldNumeric ? parseFloat(object2[field].toString().replace(/\s/g, '')) : object2[field];
        }
        if (direction === 'down') [a, b] = [b, a];
        if (a > b) return -1;
        return a < b ? 1 : 0;
      });
    },
    ...mapState([
      'filterWidth', 'currentCategorySlug', 'imageFolders',
    ]),
    objectInfoVisibility() {
      return this.$store.getters['main/objectInfoVisibility'];
    },
    isMobileDevice() {
      return this.$store.getters.isMobileDevice;
    },
  },
  mounted() {
    this.show = true;
  },
  watch: {
    currentCategorySlug() {
      this.sort = { id: 'down' };
    },
  },
  methods: {
    showObjectFullInfo(object) {
      if (!this.objectInfoVisibility[object.id].fullInfo) {
        toastr.info(this.objectInfoVisibility[object.id].title, null, {
          onclick: () => {
            this.$router.push({ name: 'lk-login' });
          },
        });
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
    checkForPdf() {
      this.disabled.downloadPdf = true;
      Http.post('/pdf/list/check', {
        objects: this.objects,
        currentCategorySlug: this.currentCategorySlug,
        check: true,
      }).then(() => {
        this.downloadPdf();
      }).catch(() => {
        toastr.warning('Что-то пошло не так, попробуйте перегрузить страницу');
      }).finally(() => {
        this.disabled.downloadPdf = false;
      });
    },
    downloadPdf() {
      toastr.info('Идет подготовка файла для скачивания');
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '/pdf/list';
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
    sortTo(column) {
      if (column === 'buildingName' && this.currentCategorySlug === 'ZU') return;
      const direction = column in this.sort && this.sort[column] === 'down' ? 'up' : 'down';
      this.sort = { [column]: direction };
    },
  },
};
</script>
