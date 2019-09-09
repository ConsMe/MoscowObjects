import Vue from 'vue';
import Vuex from 'vuex';
import { buildingTypes } from './assets/fakeData/objects';
import Http from './modules/Http';
import toastr from './components/elements/toastr';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    objectsPre: [],
    buildingTypes: [],
    currentCategorySlug: 'ZU',
    filterWidth: 0,
    objectBlockWidth: 0,
    isAuthorized: window.isAuthorized,
    isAccepted: window.isAccepted,
    user: window.user ? window.user : {},
    favoritesOffsetLeft: '60%',
    imageFolders: { big: '/storage/images/big/', small: '/storage/images/small/' },
  },
  getters: {
    objects(state) {
      return state.objectsPre.map((object) => {
        const modifiedObject = Object.assign({}, object);
        modifiedObject.cost = object.cost.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        if ('GAP' in object) {
          modifiedObject.GAP = object.GAP.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        }
        if ('areaS' in object) {
          modifiedObject.areaS = `${modifiedObject.areaS} м<sup>2</sup>`;
        }
        if ('groundS' in object) {
          modifiedObject.groundS = `${modifiedObject.groundS} Га`;
        }
        return modifiedObject;
      });
    },
    objectsForCurrentCategory(state, getters) {
      return getters.objects.filter(object => object.type === state.currentCategorySlug);
    },
  },
  mutations: {
    getAllInitData(state) {
      Http.get('/objects')
        .then((response) => {
          const objects = Object.keys(response.data).map((index) => {
            const object = response.data[index];
            const modifiedObject = Object.assign({ ...object }, object.characteristics);
            delete modifiedObject.characteristics;
            return modifiedObject;
          });
          state.objectsPre = objects;
        })
        .catch(() => toastr.warning('Обнаружены проблемы на сервере, обратитесь к разработчикам'));
      state.buildingTypes = buildingTypes;
    },
    changeCurrentCategorySlug(state, newSlug) {
      state.currentCategorySlug = newSlug;
    },
    setFilterWidth(state, width) {
      state.filterWidth = width;
    },
    setObjectBlockWidth(state, width) {
      state.objectBlockWidth = width;
    },
    changeAuthState(state, { isAuthorized, user }) {
      state.isAuthorized = isAuthorized;
      if (isAuthorized) state.user = user;
      if (user.accepted) state.isAccepted = 1;
    },
    changeSubscriptionStatus(state, status) {
      state.user.subscribed = status;
    },
    setFavoritesOffsetLeft(state, left) {
      state.favoritesOffsetLeft = `${left}px`;
    },
    removeObject(state, id) {
      state.objectsPre.some((object, i) => {
        if (id === object.id) {
          state.objectsPre.splice(i, 1);
          return true;
        }
        return false;
      });
    },
  },
  actions: {
    getAllInitData({ commit }) {
      commit('getAllInitData');
    },
  },
});
