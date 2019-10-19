<template>
  <nav class="navbar navbar-expand navbar-dark bg-dark pl-0 pr-0 shadow">
    <div class="row w-100 m-0">
      <div class="col">
        <ul class="navbar-nav row text-center">
          <li class="nav-item col-5 col-lg pl-0 pr-0" ref="brandWidth">
            <a class="navbar-brand mr-0" href="/">
              <img src="/img/title.png" style="height: 1rem;" />
            </a>
          </li>
          <li class="nav-item col-6 col-lg dropdown text-uppercase pl-0 pr-0 order-3 order-lg-1 border-sm-bottom">
            <a
              class="nav-link dropdown-toggle"
              href="/"
              id="categoryDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >{{ currentCategoryName }}</a>
            <div
              class="dropdown-menu my-dropdown-menu-center category"
              aria-labelledby="categoryDropdown"
            >
              <a
                class="dropdown-item"
                href="/"
                v-for="(category,i) in selectableCategories"
                :key="i"
                @click.prevent="changeCategory(category.slug)"
              >{{ category.name }}</a>
            </div>
          </li>
          <search-object :is-main-view="isMainView" class="order-5 order-lg-2" />
          <li class="nav-item col-6 col-lg-auto order-4 order-lg-3 border-sm-top">
            <div class="btn-group" role="group">
              <button
                type="button"
                class="btn btn-outline-dark rounded-0"
                :class="{active: activeItems.map && isMainView}"
                @click.prevent="toggleBlocks('ObjectsListBlock', false)"
              >Карта</button>
              <button
                type="button"
                class="btn btn-outline-dark rounded-0"
                :class="{active: activeItems.objectsList && isMainView}"
                @click.prevent="toggleBlocks('ObjectsListBlock', true)"
              >Список</button>
            </div>
          </li>
          <li class="nav-item col-4 col-lg-auto order-1 order-lg-4" ref="favourites">
            <a
              class="nav-link"
              href="/"
              @click.prevent="switchFavoritesState"
              :class="{active: favouritesOn}"
            >
              <i class="fa fa-heart mr-2" :class="{'text-danger': favouritesOn}"></i>
              Избранное
            </a>
          </li>
          <lk-menu-navbar class="order-2 order-lg-5" />
          <li class="nav-item col-6 col-lg text-uppercase pl-0 pr-0 order-5 order-lg-6" ref="filterWidth">
            <a
              class="nav-link dropdown-toggle"
              :class="{active: (activeItems.filter || filtersOn) && isMainView, disabled: !isMainView}"
              href="/"
              @click.prevent="toggleBlocks('FilterBlock', 'reverse')"
            >
              <span class="d-inline-block position-relative">
                Фильтр
                <button
                  class="btn btn-outline-danger btn-sm btn-reset"
                  v-if="filtersOn && isMainView"
                  @click.stop.prevent="filterReset"
                >Сброс</button>
              </span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<style lang="scss">
@import "../assets/css/_variables.scss";

.navbar {
  z-index: 3;
  border-left: none !important;
  button:focus {
    box-shadow: none !important;
  }
  .nav-link:focus {
    color: inherit;
  }
  .category {
    min-width: 12.625rem !important;
  }
  .lk {
    width: 100%;
  }
  .btn-reset {
    position: absolute;
    top: calc(50% - 0.875rem);
    left: -110%;
  }
  .navbar-brand {
    padding-top: 0.25rem !important;
  }
  @media (max-width: 991.98px){
    .nav-item {
      border: 1px solid transparent;
      padding-top: 0.7rem;
      margin-bottom: 0.4rem;
    }
    .border-sm-bottom {
      border-bottom: 1px solid $gray-500;
      border-right: 1px solid $gray-500;
    }
    .border-sm-top {
      border-top: 1px solid $gray-500;
      border-left: 0;
    }
  }
}
.my-dropdown-menu-center {
  left: 50% !important;
  transform: translateX(-50%);
  text-align: center !important;
}
.my-dropdown-menu-center:hover {
  background-color: $primary !important;
}
.fa-heart,
.fa-user {
  font-size: 1rem;
}
</style>

<script>
import SearchObject from './SearchObject.vue';
import LkMenuNavbar from './LkMenuNavbar.vue';

export default {
  components: {
    SearchObject,
    LkMenuNavbar,
  },
  data() {
    return {
      allCategories: [
        {
          name: 'Земельные участки',
          slug: 'ZU',
        },
        {
          name: 'Инвестобъекты',
          slug: 'Invest',
        },
      ],
      appName: window.APP_NAME,
      resizeTimer: null,
    };
  },
  computed: {
    currentCategoryName() {
      let currentCategory;
      this.allCategories.some((category) => {
        if (category.slug === this.currentCategorySlug) {
          currentCategory = category;
          return true;
        }
        return false;
      });
      return currentCategory ? currentCategory.name : '';
    },
    selectableCategories() {
      return this.allCategories.filter(
        category => category.slug !== this.currentCategorySlug,
      );
    },
    favouritesOn() {
      if (this.storeHasMainModule) {
        return this.$store.state.main.favouritesOn;
      }
      return false;
    },
    currentCategorySlug() {
      return this.$store.state.currentCategorySlug;
    },
    storeHasMainModule() {
      return 'main' in this.$store.state;
    },
    activeItems() {
      if (this.storeHasMainModule) {
        return this.$store.getters['main/activeItems'];
      }
      return {};
    },
    filtersOn() {
      if (this.storeHasMainModule) {
        return this.$store.state.main.filtersOn;
      }
      return false;
    },
    isMainView() {
      return ['ZU', 'Invest'].includes(this.$route.name);
    },
    mobileViewportWidth() {
      return this.$store.state.mobileViewportWidth;
    },
  },
  mounted() {
    this.$store.commit('setFavoritesOffsetLeft', this.$refs.favourites.offsetLeft);
    this.setBlocksWidth();
    window.addEventListener('resize', () => {
      this.setBlocksWidth();
    });
  },
  methods: {
    changeCategory(newSlug) {
      if (this.isMainView || ['lk-login', 'lk-register', 'lk-account'].includes(this.$route.name)) {
        this.filterReset();
        this.$store.commit('main/changeCurrentObject', {});
        this.$router.push({ name: newSlug }).catch(() => {
          this.$router.push({ name: newSlug });
        });
      } else {
        this.$store.commit('changeCurrentCategorySlug', newSlug);
      }
    },
    toggleBlocks(block, visible) {
      if (block === 'ObjectsListBlock' && this.activeItems.map === visible) {
        this.$store.commit('main/changeCurrentObject', {});
      }
      this.$store.commit('main/toggleBlocksVisibility', { block, visible });
      if (block === 'ObjectsListBlock' && !this.isMainView) {
        this.$router.push({ name: this.currentCategorySlug });
      }
    },
    switchFavoritesState() {
      this.$store.commit('main/switchFavoritesState');
      if (!this.isMainView) {
        this.$router.push({ name: this.currentCategorySlug });
      }
    },
    filterReset() {
      this.$store.commit('main/filterReset');
    },
    setBlocksWidth() {
      if (!this.resizeTimer) {
        this.resizeTimer = setTimeout(() => {
          const filterWidth = window.innerWidth >= this.mobileViewportWidth
            ? this.$refs.filterWidth.offsetWidth : null;
          const objectBlockWidth = window.innerWidth >= this.mobileViewportWidth
            ? this.$refs.brandWidth.offsetWidth : null;
          this.$store.commit('setBlocksWidth', { objectBlockWidth, filterWidth });
          this.resizeTimer = null;
        }, 500);
      }
    },
  },
};
</script>
