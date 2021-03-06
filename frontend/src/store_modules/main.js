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
    blocksVisibilityLogs: [],
    objectsListBlockScroll: 0,
    selectedFastFilters: [],
    isSelectedFastFiltersChanged: 0,
    objectFullInfoBlockOffsetBottom: 0,
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
          state.blocksVisibilityLogs.push(visibility);
          if (state.blocksVisibilityLogs.length > 5) {
            state.blocksVisibilityLogs.splice(0, 1);
          }
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
    applyFilter(state, { filters, currentCategorySlug }) {
      state.filters = filters;
      state.favouritesOn = false;
      state.filtersOn = true;
      if (['Invest', 'Retail'].includes(currentCategorySlug)) {
        const filter = currentCategorySlug === 'Invest' ? 'buildingType' : 'purposeRetail';
        state.selectedFastFilters = filters[filter].value.slice(0);
      }
    },
    filterReset(state) {
      state.filtersOn = false;
      state.filters = {};
      state.selectedFastFilters = [];
    },
    showObjectAtMap(state, coordinates) {
      state.objectCoordinatesForShow = coordinates;
    },
    addObjectsDescriptions(state, { id, description }) {
      Vue.set(state.objectsDescriptions, id, description);
    },
    setObjectsListBlockScroll(state, scroll) {
      state.objectsListBlockScroll = scroll;
    },
    selectFastFilter(state, slug) {
      const index = state.selectedFastFilters.indexOf(slug);
      if (index >= 0) {
        state.selectedFastFilters.splice(index, 1);
      } else {
        state.selectedFastFilters.push(slug);
      }
      state.isSelectedFastFiltersChanged += 1;
    },
    setObjectFullInfoBlockOffsetBottom(state, bottom) {
      state.objectFullInfoBlockOffsetBottom = bottom;
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
    modifiedFilters(state, getters, rootState) {
      if (!Object.keys(state.filters).length) return {};
      const filters = JSON.parse(JSON.stringify(state.filters));
      Object.keys(filters).forEach((name) => {
        const filter = filters[name];
        if (filter.type === 'interval') {
          const from = parseFloat(filter.values.from.replace(',', '.').replace(/\s/g, ''));
          const to = parseFloat(filter.values.to.replace(',', '.').replace(/\s/g, ''));
          filters[name].values.from = Number.isNaN(from) ? null : from;
          filters[name].values.to = Number.isNaN(to) ? null : to;
        }
      });
      if (filters.cost.currency !== 'rouble') {
        if (filters.cost.values.from) {
          filters.cost.values.from *= rootState.currencies[filters.cost.currency];
        }
        if (filters.cost.values.to) {
          filters.cost.values.to *= rootState.currencies[filters.cost.currency];
        }
      }
      return filters;
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
          if (object.type !== rootState.currentCategorySlug) return;
          const ZUType = object.ZUType === 'ЗУ' ? 'ZU' : 'OKS';
          const fit = Object.keys(getters.modifiedFilters).every((name) => {
            const filter = getters.modifiedFilters[name];
            if (filter.hidden.includes(rootState.currentCategorySlug)) return true;
            if (filter.type === 'checkbox') {
              if (filter.value.length && filter.value.length !== filter.values.length) {
                if (name === 'purpose') {
                  if (!filter.value.includes(object[name + ZUType])) return false;
                } else if (!filter.value.includes(object[name])) {
                  return false;
                }
              }
            } else if (filter.type === 'radio' && filter.value !== 'any') {
              if (filter.value !== object[name]) return false;
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
        let [title, titleText, lock, showPrice, fullInfo, priceMessage, priceMessageShort] = [
          null, null, false, true, true, null, null,
        ];
        if (!isAuthorized) {
          if (object.price_admins_only || object.only_auth) {
            title = '<span class="action">Авторизуйтесь</span>, чтобы видеть больше информации';
            titleText = 'Авторизуйтесь, чтобы видеть больше информации';
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
          priceMessageShort = 'Информация о цене закрыта';
        }
        visibility[object.id] = {
          title, titleText, lock, showPrice, fullInfo, priceMessage, priceMessageShort,
        };
      });
      return visibility;
    },
    mobileHeightStyles(state, getters, rootState, rootGetters) {
      const heightStyles = { appStyle: null, mapStyle: null };
      if (rootGetters.isMobileDevice && state.blocksVisibility.ObjectFullInfo && state.objectFullInfoBlockOffsetBottom) {
        const restWindowHeight = window.outerHeight - state.objectFullInfoBlockOffsetBottom;
        const offset = Math.round(window.outerHeight / 2) - restWindowHeight;
        if (offset > 0) {
          heightStyles.appStyle = {
            paddingBottom: `${offset}px !important`,
            height: `calc(100% + ${offset}px)`,
          };
          heightStyles.mapStyle = {
            top: `${offset}px`,
          };
        }
      }
      return heightStyles;
    },
    favouritesCount(state, getters, rootState) {
      const count = {};
      rootState.objectsPre.forEach((object) => {
        if (state.favourites.includes(object.id)) {
          const { type } = object;
          if (!count[type]) count[type] = 0;
          count[type] += 1;
        }
      });
      return count;
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
