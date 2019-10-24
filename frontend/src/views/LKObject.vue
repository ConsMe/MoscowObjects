<template>
  <div class="lk-object">
    <l-k-yandex-map
      :address="yandexSearchAddress"
      :object="object"
      @set-coordinates="setCoordinate"
      @reset-search-address="yandexSearchAddress = ''" />
    <div class="pt-5 pb-5 row shadow" :style="{width: favoritesOffsetLeft, zIndex: 1}">
      <back-button />
      <form class="col" @submit.prevent="saveObject">
        <div class="row">
          <div class="col col-8 offset-2">
            <h5 class="text-primary mb-5 text-center">{{ head + ' объекта' }}</h5>
            <div class="table-borderless">
              <table class="table table-sm">
                <tbody>
                  <tr>
                    <td width="50%" class="pr-4" colspan="2">
                      <select
                        class="custom-select border"
                        v-model="object.type"
                        required
                        title="Категория">
                        <option value="">Категория</option>
                        <option value="ZU">Земельный участок</option>
                        <option value="Invest">Инвестобъект</option>
                      </select>
                    </td>
                    <td width="50%" colspan="2"></td>
                  </tr>
                  <template v-if="object.type !== ''">
                  <tr>
                    <td width="50%" class="pr-4" colspan="2">
                      <select
                        class="custom-select border"
                        v-model="object.ZUType"
                        required
                        v-if="object.type === 'ZU'"
                        title="Тип объекта">
                          <option value="">Тип объекта</option>
                          <option value="ЗУ">Земельные участки (ЗУ)</option>
                          <option value="ОКС">ОКС под реконструкцию</option>
                      </select>
                      <select
                        class="custom-select border"
                        v-model="object.buildingType"
                        required
                        v-if="object.type === 'Invest'"
                        title="Тип объекта">
                        <option value="">Тип объекта</option>
                        <option :value="type" v-for="(type, i) in buildingTypes" :key="i">
                            {{ type.full }}
                        </option>
                      </select>
                    </td>
                    <td width="50%" colspan="2"></td>
                  </tr>
                  <tr>
                    <td width="25%">
                        <select
                          v-model="object.district"
                          class="custom-select border"
                          required
                          @change="setLocation"
                          title="Субъект">
                          <option value="">Субъект</option>
                          <option :value="district" v-for="(district, i) in districts" :key="i">
                            {{ district }}
                          </option>
                        </select>
                    </td>
                    <td colspan="3" class="address">
                      <input
                        type="text"
                        class="form-control text-center border"
                        placeholder="Адрес"
                        required
                        title="Адрес"
                        v-model="object.address"
                      />
                      <a href="" @click.prevent="yandexSearchAddress = object.address">
                        Найти на карте >>>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td width="50%" class="pr-4" :class="{borderRight: object.type === 'ZU'}" colspan="2">
                      <input
                        type="text"
                        class="form-control border"
                        placeholder="Кадастровый номер ЗУ"
                        title="Кадастровый номер ЗУ"
                        v-model="object.kadastrNumberZU"
                        v-if="object.type === 'ZU'"
                      />
                      <input
                        type="text"
                        class="form-control border"
                        placeholder="Название"
                        required
                        title="Название"
                        v-model="object.buildingName"
                        v-if="object.type === 'Invest'"
                      />
                    </td>
                    <td width="50%" class="pl-4" colspan="2">
                      <input
                        type="text"
                        class="form-control border"
                        placeholder="Кадастровый номер ОКС"
                        title="Кадастровый номер ОКС"
                        v-model="object.kadastrNumberOKS"
                        v-if="object.type === 'ZU'"
                      />
                    </td>
                  </tr>
                  <tr v-if="object.type === 'ZU'">
                    <td width="50%" class="pr-4" :class="{borderRight: object.type === 'ZU'}" colspan="2">
                      <input
                        type="text"
                        class="form-control border"
                        placeholder="Площадь ЗУ, Га"
                        required
                        title="Площадь ЗУ, Га"
                        v-model="object.groundS"
                      />
                    </td>
                    <td width="50%" class="pl-4" colspan="2">
                      <input
                        type="text"
                        class="form-control border"
                        placeholder="Площадь ОКС, кв.м."
                        :required="object.ZUType === 'ОКС'"
                        title="Площадь ОКС, кв.м."
                        v-model="object.areaS"
                      />
                    </td>
                  </tr>
                  <tr>
                    <td width="50%" class="pr-4"  :class="{borderRight: object.type === 'ZU'}" colspan="2">
                      <select
                        class="custom-select border"
                        v-model="object.purposeZU"
                        v-if="object.type === 'ZU'"
                        required
                        title="Назначение ЗУ">
                        <option value="">Назначение ЗУ</option>
                        <option value="Жилое">Жилое</option>
                        <option value="Нежилое">Нежилое</option>
                        <option value="Апартаменты">Апартаменты</option>
                      </select>
                      <input
                        type="text"
                        class="form-control border"
                        placeholder="Площадь здания, кв.м."
                        required
                        title="Площадь здания, кв.м."
                        v-model="object.areaS"
                        v-if="object.type === 'Invest'"
                      />
                    </td>
                    <td width="50%" class="pl-4" colspan="2">
                      <select class="custom-select border"
                        v-model="object.purposeOKS"
                        v-if="object.type === 'ZU'"
                        :required="object.ZUType === 'ОКС'"
                        title="Назначение ОКС">
                        <option value="">Назначение ОКС</option>
                        <option value="Жилое">Жилое</option>
                        <option value="Нежилое">Нежилое</option>
                        <option value="Апартаменты">Апартаменты</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td width="50%" class="pr-4" colspan="2">
                      <select
                        class="custom-select border"
                        v-model="object.groundPlan"
                        v-if="object.type === 'ZU'"
                        required
                        title="Наличие ГПЗУ">
                        <option value="">Наличие ГПЗУ</option>
                        <option :value="true">Есть</option>
                        <option :value="false">Нет</option>
                        <option value="in_process">В процессе</option>
                      </select>
                      <input
                        type="text"
                        class="form-control border"
                        placeholder="ГАП"
                        title="ГАП"
                        v-model="object.GAP"
                        v-if="object.type === 'Invest'"
                      />
                    </td>
                    <td width="50%" class="pl-4" colspan="2">
                      <select class="custom-select border"
                        style="width: 7rem;"
                        v-model="object.GAPCurrency"
                        :required="object.GAP.length > 0"
                        v-if="object.type === 'Invest'"
                        title="Валюта">
                          <option value="">Валюта</option>
                          <option value="rouble">руб.</option>
                          <option value="dollar">долл.</option>
                          <option value="euro">евро</option>
                      </select>
                    </td>
                  </tr>
                  <tr v-if="object.type === 'Invest'">
                    <td width="50%" class="pr-4" colspan="2">
                      <input
                        type="text"
                        class="form-control border"
                        placeholder="Caprate, %"
                        title="Caprate, %"
                        v-model="object.caprate"
                      />
                    </td>
                    <td width="50%" class="pr-4" colspan="2"></td>
                  </tr>
                  <tr>
                    <td width="50%" class="pr-4" colspan="2">
                      <input
                        type="text"
                        class="form-control border"
                        placeholder="Стоимость"
                        required
                        title="Стоимость"
                        v-model="object.cost"
                      />
                    </td>
                    <td class="pl-4 position-relative" colspan="2">
                      <select
                        class="custom-select border"
                        style="width: 7rem;"
                        v-model="object.costCurrency"
                        required
                        title="Валюта">
                        <option value="">Валюта</option>
                        <option value="rouble">руб.</option>
                        <option value="dollar">долл.</option>
                        <option value="euro">евро</option>
                      </select>
                      <input
                        type="text"
                        class="form-control border responsible"
                        placeholder="Ответственный"
                        required
                        title="Ответственный"
                        v-model="object.responsible"
                      />
                    </td>
                  </tr>
                  </template>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row justify-content-center" v-if="object.type !== ''">
          <div class="col col-10">
            <textarea
              class="form-control border"
              cols="30"
              rows="10"
              placeholder="Описание"
              title="Описание"
              v-model="object.description"
              required
            ></textarea>
          </div>
        </div>
        <div class="row justify-content-center mt-3" v-if="object.type !== ''">
          <div class="col col-10">
              <file-upload
                v-if="object.images"
                type="images"
                @uploaded="fileUploaded"
                @removed="fileRemoved"
                @add-caption="addCaption"
                @set-main-image="setMainImage"
                :files="object.images"
                :key="key"
                :object-type="object.type"
                />
          </div>
        </div>
        <div class="row justify-content-center mt-3" v-if="object.type !== ''">
          <div class="col col-10">
              <file-upload
                v-if="object.docs"
                type="docs"
                @uploaded="fileUploaded"
                @removed="fileRemoved"
                :files="object.docs"
                :key="key"
                :object-type="object.type"
                />
          </div>
        </div>
        <div class="row justify-content-center mt-3" v-if="object.type !== ''">
          <div class="col col-auto mt-3">
              <div class="custom-control custom-switch mb-1">
                <input type="checkbox"
                  class="custom-control-input"
                  id="onlyAuth"
                  v-model="object.only_auth"
                  :disabled="object.object_admins_only">
                <label
                  class="custom-control-label"
                  for="onlyAuth">
                  Ограничить доступ гостям
                </label>
             </div>
             <div class="custom-control custom-switch mb-1">
                <input type="checkbox"
                  class="custom-control-input"
                  id="priceAdminsOnly"
                  v-model="object.price_admins_only"
                  :disabled="object.object_admins_only">
                <label
                  class="custom-control-label"
                  for="priceAdminsOnly">
                  Показывать цену только группе администратора
                </label>
             </div>
             <div class="custom-control custom-switch mb-1">
                <input type="checkbox"
                  class="custom-control-input"
                  id="objectAdminsOnly"
                  v-model="object.object_admins_only"
                  @change="syncScope">
                <label
                  class="custom-control-label"
                  for="objectAdminsOnly">
                  Показывать объект только группе администратора
                </label>
             </div>
             <div class="custom-control custom-switch mb-1">
                <input type="checkbox"
                  class="custom-control-input"
                  id="hideCompanyInfoInTizer"
                  v-model="object.hide_company_info_in_tizer">
                <label
                  class="custom-control-label"
                  for="hideCompanyInfoInTizer">
                  Скрывать в тизере информацию о компании
                </label>
             </div>
          </div>
        </div>
        <div class="row justify-content-center mt-5" v-if="object.type !== ''">
          <div class="col col-4">
              <button
                class="btn btn-primary btn-block"
                type="submit"
                :disabled="disabled">
                <span :class="{invisible: disabled}">
                  {{ buttonName }}
                </span>
                <span
                  class="spinner-border text-white spinner spinner-border-sm"
                  :class="{invisible: !disabled}"
                   role="status">
                    <span class="sr-only">Loading...</span>
                </span>
              </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<style lang="scss">
.lk-object {
  display: flex;
  flex-direction: row;
  flex: 1;
  position: relative;
  ::placeholder {
    color: gray;
  }
  .responsible {
    top: 0px;
    right: -25%;
    margin: auto;
    width: 12rem;
    bottom: 0;
    position: absolute;
  }
  @media (min-width: 1281px) {
    .responsible {
      width: 15rem;
    }
  }
  .fa-file-picture-o {
    font-size: 8rem;
    line-height: 10rem;
    opacity: 0.5;
  }
  .pointer {
    cursor: pointer;
  }
  .spinner {
    position: absolute;
    margin: auto;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
  }
  .address {
    position: relative;
  }
  .address a {
    position: absolute;
    left: calc(100% + 2rem);
    top: 30%;
    white-space: nowrap;
  }
  .custom-switch .custom-control-label::before {
    left: -2.45rem;
    width: 1.95rem;
    border-radius: .6rem;
  }
  .custom-control-label::before {
    width: 1.2rem;
    height: 1.2rem;
    top: .05rem;
  }
  .custom-switch .custom-control-label::after {
    top: calc(0.05rem + 2px);
    left: calc(-2.45rem + 2px);
    width: calc(1.2rem - 4px);
    height: calc(1.2rem - 4px);
  }
  .custom-control-label::after {
    left: -1.7rem;
  }
}
.lk-object > .row {
  overflow-y: auto;
  overflow-x: hidden;
  position: relative;
}
</style>

<script>
import Vue from 'vue';
import toastr from '../components/elements/toastr';
import Http from '../modules/Http';
import FileUpload from '../components/FileUpload.vue';
import objectFields from '../assets/data/objectsFields';
import buildingTypes from '../assets/data/buildingTypes';
import LKYandexMap from '../components/LKYandexMap.vue';
import BackButton from '../components/elements/BackButton.vue';

export default {
  name: 'LKObject',
  components: {
    FileUpload, LKYandexMap, BackButton,
  },
  data() {
    return {
      object: {},
      key: Math.random(),
      objectFields,
      buildingTypes,
      disabled: false,
      districts: ['Москва, ЦАО', 'Москва, САО', 'Москва, СВАО', 'Москва, ВАО', 'Москва, ЮВАО', 'Москва, ЮАО', 'Москва, ЮЗАО', 'Москва, ЗАО', 'Москва, СЗАО', 'Новая Москва и Зеленоград', 'Московская область'],
      yandexSearchAddress: '',
    };
  },
  mounted() {
    this.init(this.$route.params.id);
  },
  beforeRouteUpdate(to, from, next) {
    this.object = {};
    this.key = Math.random();
    this.init(to.params.id);
    next();
  },
  computed: {
    favoritesOffsetLeft() {
      return this.$store.state.favoritesOffsetLeft;
    },
    isNew() {
      return ['new', 'clone'].includes(this.$route.params.id);
    },
    head() {
      return this.isNew ? 'Размещение' : 'Редактирование';
    },
    buttonName() {
      return this.isNew ? 'Разместить объект' : 'Сохранить изменения';
    },
    allObjectFields() {
      return this.objectFields.any.concat(this.objectFields.ZU, this.objectFields.Invest);
    },
  },
  methods: {
    init(id) {
      if (typeof id === 'number' || id.match(/\d+/)) {
        this.getObject(id);
      } else if (id === 'clone') {
        if (!this.$route.params.clone_id) return this.$router.push({ name: 'lk-objects' });
        this.getObject(this.$route.params.clone_id);
      } else {
        this.object = this.checkIfObjectHasAllFields({});
      }
      return null;
    },
    getObject(id) {
      Http.get(`/objects/${id}/edit`)
        .then((response) => {
          const { data } = response;
          const object = Object.assign(data.characteristics, {
            description: data.description,
            responsible: data.responsible,
            only_auth: data.only_auth,
            price_admins_only: data.price_admins_only,
            object_admins_only: data.object_admins_only,
            hide_company_info_in_tizer: data.hide_company_info_in_tizer,
            images: {},
            docs: {},
          });
          if (this.$route.params.id !== 'clone') {
            data.images.forEach((image) => {
              object.images[image.id] = image;
            });
            data.docs.forEach((doc) => {
              object.docs[doc.id] = doc;
            });
          }
          this.object = this.checkIfObjectHasAllFields(object);
        })
        .catch(() => {
          this.$router.push({ name: 'lk-objects' });
        });
    },
    fileUploaded(response, type) {
      Vue.set(this.object[type], response.id, response);
    },
    fileRemoved(uuid, type) {
      if (!this.object[type][uuid].object_id) {
        const { id, filename } = this.object[type][uuid];
        Http.post(`/files/${id}`, { filename }, { params: { _method: 'DELETE' } })
          .catch(() => {
            toastr.warning('Что пошло не так, перегрузите страницу');
          });
      }
      Vue.delete(this.object[type], uuid);
    },
    addCaption(id, caption) {
      this.object.images[id].caption = caption;
    },
    setMainImage(setId) {
      Object.keys(this.object.images).forEach((id) => {
        if (setId && id === setId) {
          this.object.images[id].isMain = 1;
        } else {
          this.object.images[id].isMain = 0;
        }
      });
    },
    saveObject() {
      if (!Object.keys(this.object.images).length) {
        toastr.warning('Добавьте изображение объекта');
        return;
      }
      this.disabled = true;
      const object = JSON.parse(JSON.stringify(this.object));
      const requiredFields = this.objectFields.any.concat(this.objectFields[object.type]);
      Object.keys(object).forEach((key) => {
        if (!requiredFields.includes(key)) {
          delete object[key];
          return;
        }
        if (this.objectFields.numericFields.includes(key) && typeof object[key] === 'string') {
          object[key] = object[key].replace(/\s/g, '').replace(',', '.');
        }
      });
      if (object.ZUType === 'ЗУ') {
        if (!object.areaS.toString().length) delete object.areaS;
        if (!object.kadastrNumberOKS.toString().length) delete object.kadastrNumberOKS;
        if (!object.purposeOKS.toString().length) delete object.purposeOKS;
      }
      if (object.type === 'ZU') {
        if (!object.kadastrNumberZU.toString().length) delete object.kadastrNumberZU;
      } else if (object.type === 'Invest') {
        if (!object.caprate.toString().length) delete object.caprate;
        if (!object.GAP.toString().length) {
          delete object.GAP;
          delete object.GAPCurrency;
        }
      }
      const params = { data: object, method: 'post' };
      params.url = this.isNew ? '/objects' : `/objects/${this.$route.params.id}?_method=PUT`;
      Http.request(params).then((response) => {
        if (this.isNew) {
          this.$router.push({ name: 'lk-object', params: { id: response.data } });
          toastr.success('Новый объект добавлен');
          return;
        }
        const { images, docs } = response.data;
        Object.keys(images).forEach((id) => {
          this.object.images[id].object_id = images[id].object_id;
          this.object.images[id].filename = images[id].filename;
        });
        Object.keys(docs).forEach((id) => {
          this.object.docs[id].object_id = docs[id].object_id;
        });
        toastr.success('Изменения сохранены');
      }).catch((error) => {
        if (error.response && error.response.data.errors) {
          const errors = Object.values(error.response.data.errors);
          if (errors.length) {
            toastr.warning(errors[0]);
          } else {
            toastr.warning('Проверьте, все ли поля заполнены верно');
          }
          return;
        }
        toastr.warning('Что-то пошло не так, обратитесь к разработчикам');
      }).finally(() => {
        this.disabled = false;
      });
    },
    checkIfObjectHasAllFields(object) {
      const checkedObject = object;
      this.allObjectFields.forEach((field) => {
        if (!(field in object)) {
          if (['only_auth', 'price_admins_only', 'object_admins_only', 'hide_company_info_in_tizer'].includes(field)) {
            checkedObject[field] = false;
          } else if (['images', 'docs'].includes(field)) {
            checkedObject[field] = {};
          } else {
            checkedObject[field] = '';
          }
        }
      });
      return checkedObject;
    },
    setLocation() {
      if (this.object.district.indexOf('Новая') >= 0) {
        this.object.location = 'New_Moscow';
      } else if (this.object.district.indexOf('область') >= 0) {
        this.object.location = 'MO';
      } else if (this.object.district === '') {
        this.object.location = '';
      } else {
        this.object.location = 'Moscow';
      }
    },
    setCoordinate(coordinates) {
      this.object.coordinates = coordinates;
    },
    syncScope() {
      if (this.object.object_admins_only) {
        this.object.only_auth = false;
        this.object.price_admins_only = false;
      }
    },
  },
};
</script>
