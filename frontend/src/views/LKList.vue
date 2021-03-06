<template>
  <div class="mt-5 lk-list">
    <back-button :class="{'d-none': !objectBlockWidth}" />
    <h5
      :style="{paddingLeft: objectBlockWidth + 'px'}"
      class="text-primary mb-5"
      :class="{'d-none': !objectBlockWidth}"
    >Управление каталогом</h5>
    <div class="row mb-5" :style="{maxWidth: maxWidth + 'px'}">
      <div class="col">
        <table class="table table-hover m-0 sticky-thead" v-if="objects.length">
          <thead class="thead-light">
            <tr>
              <th scope="col" class="pl-4">Дата</th>
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
              <template v-else-if="currentCategorySlug === 'Invest'">
                <th scope="col">Тип</th>
                <th scope="col">S</th>
                <th scope="col">ГАП, ₽</th>
                <th scope="col">Caprate</th>
              </template>
              <template v-else-if="currentCategorySlug === 'Retail'">
                <th scope="col">Назначение</th>
                <th scope="col">S</th>
                <th scope="col">МАП, ₽</th>
                <th scope="col">Окупаемость</th>
              </template>
              <th scope="col">Стоимость, ₽</th>
              <th scope="col">Ответственный</th>
              <th scope="col">Действия</th>
            </tr>
          </thead>
          <tbody>
            <tr class="bg-white" v-for="object in objects" :key="object.id">
              <td class="align-middle pl-4">{{ moment(object.updated_at).format('DD.MM.YYYY') }}</td>
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
                <td class="align-middle">{{ object.groundPlan.short }}</td>
              </template>
              <template v-else-if="currentCategorySlug === 'Invest'">
                <td class="align-middle">{{ buildingTypes[object.buildingType].short }}</td>
                <td class="align-middle text-nowrap" v-html="object.areaS"></td>
                <td class="align-middle text-nowrap">{{ object.GAP }}</td>
                <td class="align-middle">{{ object.caprate + '%' }}</td>
              </template>
              <template v-else-if="currentCategorySlug === 'Retail'">
                <td class="align-middle">{{ purposesRetail[object.purposeRetail].short }}</td>
                <td class="align-middle text-nowrap" v-html="object.areaS"></td>
                <td class="align-middle text-nowrap">{{ object.MAP }}</td>
                <td class="align-middle">{{ object.payback }}</td>
              </template>
              <td class="align-middle text-nowrap">{{ object.cost }}</td>
              <td class="align-middle">{{ object.responsible }}</td>
              <td class="align-middle text-nowrap">
                <router-link
                  class="btn btn-outline-primary btn-sm mr-1"
                  title="редактировать"
                  :to="{name: 'lk-object', params: {id: object.id}}">
                    <i class="fa fa-pencil"></i>
                </router-link>
                <router-link
                  class="btn btn-outline-secondary btn-sm mr-1"
                  title="клонировать"
                  :to="{name: 'lk-object', params: {id: 'clone', clone_id: object.id}}">
                    <i class="fa fa-clone"></i>
                </router-link>
                <button
                  class="btn btn-outline-danger btn-sm mr-1"
                  title="удалить"
                  type="button"
                   @click.prevent="removeObject(object.id)">
                    <i class="fa fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.lk-list {
  .rounded-circle {
    width: 1.75rem;
  }
  .sticky-thead tr > th {
    position: sticky;
    top: -1px;
    z-index: 1;
  }
}
</style>

<script>
import moment from 'moment';
import toastr from '../components/elements/toastr';
import Http from '../modules/Http';
import BackButton from '../components/elements/BackButton.vue';
import buildingTypes from '../assets/data/buildingTypes';
import purposesRetail from '../assets/data/purposesRetail';

export default {
  name: 'LKList',
  components: { BackButton },
  data() {
    return {
      moment,
      buildingTypes,
      purposesRetail,
    };
  },
  mounted() {
    this.$store.commit('getAllInitData');
  },
  computed: {
    objectBlockWidth() {
      return this.$store.state.objectBlockWidth;
    },
    maxWidth() {
      return window.innerWidth - this.$store.state.filterWidth;
    },
    objects() {
      return this.$store.getters.objectsForCurrentCategory;
    },
    currentCategorySlug() {
      return this.$store.state.currentCategorySlug;
    },
  },
  methods: {
    removeObject(id) {
      if (window.confirm('Будет удалена вся информация об объекте и все его файлы. Удалить объект?')) {
        Http.post(`/objects/${id}`, null, { params: { _method: 'DELETE' } })
          .then(() => {
            toastr.success('Объект успешно удален');
            this.$store.commit('removeObject', id);
          })
          .catch(() => {
            toastr.warning('Что пошло не так, перегрузите страницу');
          });
      }
    },
  },
};
</script>
