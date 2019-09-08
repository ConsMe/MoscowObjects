import Vue from 'vue';
import Http from '../modules/Http';

export default {
  namespaced: true,
  state: {
    blocksVisibility: {
      ObjectsListBlock: false,
      ObjectBlock: false,
      ObjectFullInfo: false,
      FilterBlock: false,
    },
    foundedObject: {},
    favourites: [],
    favouritesOn: false,
    currentObject: {},
    filters: {},
    filtersOn: false,
    objectCoordinatesForShow: [],
    objectsDescriptions: {},
    isYmapReady: window.ymapsState,
  },
  mutations: {
    getAllInitData(state, isAuthorized) {
      if (isAuthorized) {
        Http.get('/favourites').then((response) => {
          state.favourites = response.data;
        });
      } else {
        const favourites = localStorage.getItem('favourites');
        state.favourites = favourites ? JSON.parse(favourites) : [];
      }
    },
    toggleBlocksVisibility(state, { block, visible }) {
      if (block === 'FilterBlock' || !visible) {
        if (visible === 'reverse') {
          state.blocksVisibility[block] = !state.blocksVisibility[block];
        } else {
          state.blocksVisibility[block] = visible;
        }
        return;
      }
      Object.keys(state.blocksVisibility).forEach((visibility) => {
        if (visibility === 'FilterBlock') return;
        if (visibility === block) {
          state.blocksVisibility[visibility] = visible;
          return;
        }
        state.blocksVisibility[visibility] = false;
      });
    },
    gotSearchResult(state, object) {
      state.foundedObject = null;
      state.foundedObject = object;
    },
    toggleObjectFavourite(state, { id, value, isAuthorized }) {
      const idPosition = state.favourites.indexOf(id);
      if (value && idPosition < 0) {
        state.favourites.push(id);
      } else if (!value && idPosition >= 0) {
        state.favourites.splice(idPosition, 1);
      }
      if (!isAuthorized) {
        const localFavouritesString = localStorage.getItem('favourites');
        const localFavourites = localFavouritesString ? JSON.parse(localFavouritesString) : [];
        const localIdPosition = localFavourites.indexOf(id);
        if (value && localIdPosition < 0) {
          localFavourites.push(id);
          localStorage.setItem('favourites', JSON.stringify(localFavourites));
        } else if (!value && localIdPosition >= 0) {
          localFavourites.splice(localIdPosition, 1);
          localStorage.setItem('favourites', JSON.stringify(localFavourites));
        }
      }
    },
    switchFavoritesState(state, favouritesOn = 'reverse') {
      if (favouritesOn === 'reverse') {
        state.favouritesOn = !state.favouritesOn;
      } else {
        state.favouritesOn = favouritesOn;
      }
      if (state.favouritesOn) state.filtersOn = false;
    },
    changeCurrentObject(state, object) {
      state.currentObject = object;
    },
    applyFilter(state, filters) {
      state.filters = Object.assign({}, filters);
      state.favouritesOn = false;
      state.filtersOn = true;
    },
    filterReset(state) {
      state.filtersOn = false;
    },
    showObjectAtMap(state, coordinates) {
      state.objectCoordinatesForShow = coordinates;
    },
    addObjectsDescriptions(state, { id, description }) {
      Vue.set(state.objectsDescriptions, id, description);
    },
  },
  getters: {
    activeItems(state) {
      return {
        filter: state.blocksVisibility.FilterBlock,
        objectsList: state.blocksVisibility.ObjectsListBlock,
        map: !state.blocksVisibility.ObjectsListBlock,
      };
    },
    objects(state, getters, rootState, rootGetters) {
      if (state.favouritesOn) {
        return rootGetters.objectsForCurrentCategory.filter((object) => {
          if (state.favourites.includes(object.id)) return true;
          return false;
        });
      }
      if (state.filtersOn) {
        const matchIds = [];
        rootState.objectsPre.forEach((object) => {
          const ZUType = object.ZUType === 'ЗУ' ? 'ZU' : 'OKS';
          const fit = Object.keys(state.filters).every((name) => {
            const filter = state.filters[name];
            if (filter.type === 'checkbox') {
              if (filter.value.length && filter.value.length !== filter.values.length) {
                if (!filter.value.includes(object[name])) return false;
              }
            } else if (filter.type === 'radio' && filter.value !== 'any') {
              if (name === 'purpose') {
                if (filter.value !== object[name + ZUType]) return false;
              } else if (filter.value !== object[name]) {
                return false;
              }
            } else if (filter.type === 'interval') {
              if (filter.values.from && object[name] < filter.values.from) return false;
              if (filter.values.to && object[name] > filter.values.to) return false;
            }
            return true;
          });
          if (fit) matchIds.push(object.id);
        });
        return rootGetters.objectsForCurrentCategory.filter(object => matchIds.includes(object.id));
      }
      return rootGetters.objectsForCurrentCategory;
    },
    objectInfoVisibility(state, getters, rootState, rootGetters) {
      const { isAuthorized } = rootState;
      const { role, accepted } = rootState.user;
      const visibility = {};
      rootGetters.objects.forEach((object) => {
        let [title, lock, showPrice, fullInfo, priceMessage] = [null, false, true, true, null];
        if (!isAuthorized) {
          if (object.price_admins_only || object.only_auth) {
            title = 'Авторизуйтесь, чтобы видеть больше информации';
            showPrice = false;
          }
          if (object.only_auth) {
            fullInfo = false;
          }
        } else if (!accepted) {
          if (object.price_admins_only || object.only_auth) {
            title = 'Информация недоступна, т.к. ваш аккаунт еще не прошел проверку';
            showPrice = false;
            lock = true;
          }
          if (object.only_auth) {
            fullInfo = false;
          }
        } else if (object.price_admins_only && !['admin', 'manager'].includes(role)) {
          showPrice = false;
          priceMessage = 'Информация о цене объекта закрыта';
        }
        visibility[object.id] = {
          title, lock, showPrice, fullInfo, priceMessage,
        };
      });
      return visibility;
    },
  },
  actions: {
    getAllInitData(context) {
      context.commit('getAllInitData', context.rootState.isAuthorized);
    },
    toggleObjectFavourite(context, { id, value }) {
      const { isAuthorized } = context.rootState;
      context.commit('toggleObjectFavourite', { id, value, isAuthorized });
    },
  },
};
