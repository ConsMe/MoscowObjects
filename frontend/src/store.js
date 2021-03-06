import Vue from 'vue';
import Vuex from 'vuex';
import Http from './modules/Http';
import toastr from './components/elements/toastr';
import mainModule from './store_modules/main';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    objectsPre: [],
    currentCategorySlug: '',
    filterWidth: null,
    objectBlockWidth: null,
    isAuthorized: window.isAuthorized,
    isAccepted: window.isAccepted,
    user: window.user ? window.user : {},
    favoritesOffsetLeft: '60%',
    imageFolders: { big: '/storage/images/big/', small: '/storage/images/small/' },
    currencies: { USD: 1, EUR: 1 },
    mobileViewportWidth: 992,
    windowInnerWidth: window.innerWidth,
  },
  modules: {
    main: mainModule,
  },
  getters: {
    objects(state) {
      return state.objectsPre.map((object) => {
        const modifiedObject = Object.assign({}, object);
        modifiedObject.cost = object.cost.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        if ('GAP' in object) {
          modifiedObject.GAP = object.GAP.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        }
        if ('MAP' in object) {
          modifiedObject.MAP = object.MAP.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        }
        if ('areaS' in object) {
          modifiedObject.areaS = `${modifiedObject.areaS.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ')} м<sup>2</sup>`;
        }
        if ('groundS' in object) {
          const float = parseFloat(modifiedObject.groundS);
          const round = Math.round(float * 10000) / 10000;
          modifiedObject.groundS = `${round} Га`;
        }
        if ('groundPlan' in object) {
          if (object.groundPlan === true) {
            modifiedObject.groundPlan = {
              short: 'Есть',
              full: 'ГПЗУ',
              mobile: 'ГПЗУ',
              is: true,
            };
          } else if (object.groundPlan === false) {
            modifiedObject.groundPlan = {
              short: 'Нет',
              full: '',
              mobile: '',
              is: false,
            };
          } else if (object.groundPlan === 'in_process') {
            modifiedObject.groundPlan = {
              short: 'Проц',
              full: 'ГПЗУ в процессе',
              mobile: 'ГПЗУ проц',
              is: true,
            };
          }
        }
        if ('payback' in object) {
          let text = 'лет';
          const count = object.payback.toString();
          if (object.payback || object.payback < 10) {
            if (count === '1') {
              text = 'год';
            } else if (count.length > 1 && count[count.length - 1] === '1' && count[count.length - 2] !== '1') {
              text = 'год';
            } else if (['2', '3', '4'].includes(count[count.length - 1])) {
              text = 'года';
            }
          }
          modifiedObject.payback = `${object.payback} ${text}`;
        }
        return modifiedObject;
      });
    },
    objectsForCurrentCategory(state, getters) {
      return getters.objects.filter(object => object.type === state.currentCategorySlug);
    },
    isMobileDevice(state) {
      return state.windowInnerWidth < state.mobileViewportWidth;
    },
  },
  mutations: {
    getAllInitData(state) {
      Http.get('/objects')
        .then((response) => {
          state.currencies.USD = parseFloat(response.data.currencies.USD.value);
          state.currencies.EUR = parseFloat(response.data.currencies.EUR.value);
          const objects = Object.keys(response.data.objects).map((index) => {
            const object = response.data.objects[index];
            const modifiedObject = Object.assign({ ...object }, object.characteristics);
            delete modifiedObject.characteristics;
            if (modifiedObject.costCurrency !== 'rouble') {
              const costCurrency = modifiedObject.costCurrency === 'dollar' ? 'USD' : 'EUR';
              modifiedObject.cost = Math.round(modifiedObject.cost * state.currencies[costCurrency]);
              modifiedObject.costCurrency = 'rouble';
            }
            if ('GAP' in modifiedObject && modifiedObject.GAPCurrency !== 'rouble') {
              const GAPCurrency = modifiedObject.GAPCurrency === 'dollar' ? 'USD' : 'EUR';
              modifiedObject.GAP = Math.round(modifiedObject.GAP * state.currencies[GAPCurrency]);
              modifiedObject.GAPCurrency = 'rouble';
            }
            if ('MAP' in modifiedObject && modifiedObject.MAPCurrency !== 'rouble') {
              const MAPCurrency = modifiedObject.MAPCurrency === 'dollar' ? 'USD' : 'EUR';
              modifiedObject.MAP = Math.round(modifiedObject.MAP * state.currencies[MAPCurrency]);
              modifiedObject.MAPCurrency = 'rouble';
            }
            return modifiedObject;
          });
          state.objectsPre = objects;
        })
        .catch(() => toastr.warning('Обнаружены проблемы на сервере, обратитесь к разработчикам'));
    },
    changeCurrentCategorySlug(state, newSlug) {
      state.currentCategorySlug = newSlug;
    },
    setBlocksWidth(state, { objectBlockWidth, filterWidth }) {
      state.objectBlockWidth = objectBlockWidth;
      state.filterWidth = filterWidth;
      state.windowInnerWidth = window.innerWidth;
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
