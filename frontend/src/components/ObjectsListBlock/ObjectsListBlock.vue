<template>
  <div class="objects-list-block shadow" ref="objectsListBlock" :style="{width: isMobileDevice ? '100%' : '60%'}">
    <div class="row m-0 pb-0" v-if="!isMobileDevice" ref="scrollableDesktop">
      <div class="col p-0 pb-1">
        <table class="table table-hover m-0 sticky-thead">
          <thead>
            <sort-header :is-mobile-device="isMobileDevice" :sort="sort" @sort-to="sortTo" />
          </thead>
          <tbody>
            <tr
              class="bg-white"
              v-for="object in objects"
              :key="object.id"
              @click="showObjectFullInfo(object)"
              :title="objectInfoVisibility[object.id].titleText"
            >
              <td width="25%">
                <span class="position-relative d-inline-block overflow-hidden">
                  <img :src="imageFolders.small + object.images[0].filename" alt="Фото" class="img-fluid" />
                  <span
                    class="bg-primary text-white pr-2 pl-2 pt-1 pb-1 image-type"
                    v-if="['ZU', 'Retail'].includes(currentCategorySlug) && object.images[0].caption"
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
                <td class="align-middle">{{ object.groundPlan.short }}</td>
              </template>
              <template v-else-if="currentCategorySlug === 'Invest'">
                <td class="align-middle">{{ buildingTypes[object.buildingType].short }}</td>
                <td class="align-middle text-nowrap" v-html="object.areaS"></td>
                <td class="align-middle text-nowrap">{{ object.GAP }}</td>
                <td class="align-middle">{{ object.caprate ? `${object.caprate}%` : '' }}</td>
              </template>
              <template v-else-if="currentCategorySlug === 'Retail'">
                <td class="align-middle">{{ purposesRetail[object.purposeRetail].shortDestop }}</td>
                <td class="align-middle text-nowrap" v-html="object.areaS"></td>
                <td class="align-middle text-nowrap">{{ object.MAP }}</td>
                <td class="align-middle text-nowrap text-center">{{ object.payback ? object.payback : '' }}</td>
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
      <div style="border: 1px solid #282828;">
        <sort-header :is-mobile-device="isMobileDevice" :sort="sort" @sort-to="sortTo" />
      </div>
      <div
        class="row m-0 mt-4 pb-0"
        v-for="object in objects"
        :key="object.id"
        @click="showObjectFullInfo(object)">
        <object-info :object="object" :isMobileDevice="isMobileDevice" type="list" />
      </div>
    </template>
    <transition name="bounce" v-if="!isMobileDevice && isAuthorized">
      <span class="download-list" v-show="show">
        <button
          class="btn btn-yellow rounded-0 border border-left-0"
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
@import "../../assets/css/_variables.scss";

.objects-list-block {
  position: absolute;
  left: 0;
  z-index: 2;
  background: #060606;
  max-height: 100%;

  @media (max-width: 1099.98px){
    & {
      overflow-y: auto;
      overflow-x: hidden;
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
  @media (min-width: 1100px){
    & {
      display: flex;
      flex-direction: column;
    }
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
  .underground {
    img {
      height: .7rem;
    }
    * {
      vertical-align: middle;
    }
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

  & > button {
    border-color: white !important;
    box-shadow: 5px 5px 5px 0px rgba(0,0,0,.51) !important;
  }
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
import FavouriteIcon from '../elements/FavouriteIcon.vue';
import toastr from '../elements/toastr';
import Http from '../../modules/Http';
import objectsFields from '../../assets/data/objectsFields';
import buildingTypes from '../../assets/data/buildingTypes';
import purposesRetail from '../../assets/data/purposesRetail';
import SortHeader from './SortHeader.vue';
import ObjectInfo from './ObjectMobileInfo.vue';

export default {
  name: 'ObjectsListBlock',
  components: {
    FavouriteIcon, SortHeader, ObjectInfo,
  },
  data() {
    return {
      show: false,
      disabled: {
        downloadPdf: false,
      },
      sort: { id: 'down' },
      numericFields: ['id', ...objectsFields.numericFields],
      buildingTypes,
      purposesRetail,
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
        } else if (field === 'groundPlan') {
          a = object1.groundPlan.short;
          b = object2.groundPlan.short;
        } else if (field === 'type' && this.currentCategorySlug === 'Invest') {
          a = this.buildingTypes[object1.buildingType].short;
          b = this.buildingTypes[object2.buildingType].short;
        } else if (field === 'purposeRetail' && this.currentCategorySlug === 'Retail') {
          a = this.purposesRetail[object1.purposeRetail].short;
          b = this.purposesRetail[object2.purposeRetail].short;
        } else {
          if (!object1[field]) {
            a = isFieldNumeric ? 0 : '';
          } else {
            a = isFieldNumeric ? parseFloat(object1[field].toString().replace(/\s/g, '')) : object1[field];
          }
          if (!object2[field]) {
            b = isFieldNumeric ? 0 : '';
          } else {
            b = isFieldNumeric ? parseFloat(object2[field].toString().replace(/\s/g, '')) : object2[field];
          }
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
      if (this.$store.getters.isMobileDevice > 0) {
        return window.innerWidth < 1100;
      }
      return window.innerWidth < 1100;
    },
    isAuthorized() {
      return this.$store.state.isAuthorized;
    },
  },
  mounted() {
    this.show = true;
    const blocksLogs = this.$store.state.main.blocksVisibilityLogs;
    const prevBlock = blocksLogs.length > 1 ? blocksLogs[blocksLogs.length - 2] : null;
    if (prevBlock === 'ObjectFullInfo') {
      const scroll = this.$store.state.main.objectsListBlockScroll;
      setTimeout(() => {
        const block = this.isMobileDevice ? this.$refs.objectsListBlock : this.$refs.scrollableDesktop;
        block.scrollTop = scroll;
      }, 0);
    }
  },
  watch: {
    currentCategorySlug() {
      this.sort = { id: 'down' };
      setTimeout(() => {
        const block = this.isMobileDevice ? this.$refs.objectsListBlock : this.$refs.scrollableDesktop;
        block.scrollTop = 0;
      }, 0);
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
      const scroll = this.isMobileDevice ? this.$refs.objectsListBlock.scrollTop : this.$refs.scrollableDesktop.scrollTop;
      this.$store.commit('main/setObjectsListBlockScroll', scroll);
      this.$router.push({ name: this.currentCategorySlug, params: { objectId: object.id.toString() } });
    },
    showObjectAtMap(object) {
      this.$store.commit('main/changeCurrentObject', object);
      this.$store.commit('main/showObjectAtMap', object.coordinates);
    },
    checkForPdf() {
      this.disabled.downloadPdf = true;
      const objects = JSON.parse(JSON.stringify(this.objects));
      if (['Invest', 'Retail'].includes(this.currentCategorySlug)) {
        objects.forEach((object, i) => {
          if (this.currentCategorySlug === 'Invest') {
            objects[i].buildingType = { short: this.buildingTypes[object.buildingType].short };
          } else if (this.currentCategorySlug === 'Retail') {
            objects[i].purposeRetail = { short: this.purposesRetail[object.purposeRetail].short };
          }
        });
      }
      Http.post('/pdf/list/check', {
        objects,
        currentCategorySlug: this.currentCategorySlug,
        check: true,
      }).then(() => {
        this.downloadPdf(objects);
      }).catch(() => {
        toastr.warning('Что-то пошло не так, попробуйте перегрузить страницу');
      }).finally(() => {
        this.disabled.downloadPdf = false;
      });
    },
    downloadPdf(objects) {
      toastr.info('Идет подготовка файла для скачивания');
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '/pdf/list';
      const input = document.createElement('input');
      input.name = 'objects';
      input.value = JSON.stringify(objects);
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
    sortTo(field, direction) {
      this.sort = { [field]: direction };
    },
  },
};
</script>
