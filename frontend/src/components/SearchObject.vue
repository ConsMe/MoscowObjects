<template>
  <li class="nav-item col-6 col-lg-auto dropdown">
    <form @submit.prevent>
      <input
        class="form-control bg-transparent border-white text-white"
        :class="{disabled: !isMainView}"
        type="text"
        placeholder="Лот или адрес"
        v-model="text"
        :disabled="disabled || !isMainView"
        @keyup.esc="clearForm"
        @blur="closeDropdown"
        @focus="focusInput"
      />
    </form>
    <div
      class="dropdown-menu dropdown-search"
      ref="searchDropdown"
      :style="{ opacity }"
    >
      <template v-if="foundedObjects.length">
        <a
          v-for="object in foundedObjects"
          :key="object.id"
          class="dropdown-item text-truncate"
          href="/"
          @click="chooseObject(object)"
        >{{ 'Лот ' + object.id + ', ' + object.address }}</a>
      </template>
      <template v-else>
        <span class="dropdown-item notfound" >
          Ничего не найдено
        </span>
      </template>
    </div>
  </li>
</template>

<style lang="scss" scoped>
@import "../assets/css/_variables.scss";

input[type="text"] {
  border-color: $gray-400 !important;
}
input[type="text"].disabled {
  border-color: #ffffff80 !important;
  color: #ffffff80 !important;
}
.dropdown-search {
  width: auto;
  overflow: hidden;

  span:hover {
    background-color: initial;
  }
}
</style>

<script>
import $ from 'jquery';

export default {
  name: 'SearchObject',
  props: ['isMainView'],
  data() {
    return {
      text: '',
      disabled: false,
      minSearchStringLength: 1,
      opacity: 1,
    };
  },
  computed: {
    objects() {
      return this.$store.getters.objects;
    },
    modifiedText() {
      return this.text.trim().replace('  ', ' ');
    },
    foundedObjects() {
      if (this.modifiedText.length >= this.minSearchStringLength) {
        const textRegexp = new RegExp(this.modifiedText, 'i');
        const foundedObjects = this.objects.filter((object) => {
          const concatObjectInfo = object.id + object.address;
          return concatObjectInfo.match(textRegexp);
        });
        if (foundedObjects.length > 10) foundedObjects.length = 10;
        return foundedObjects;
      }
      return [];
    },
    currentCategorySlug() {
      return this.$store.state.currentCategorySlug;
    },
    objectInfoVisibility() {
      return this.$store.getters['main/objectInfoVisibility'];
    },
  },
  watch: {
    text(nv, ov) {
      if (nv.length >= this.minSearchStringLength) {
        if (ov.length < this.minSearchStringLength) $(this.$refs.searchDropdown).dropdown('show');
      }
    },
  },
  methods: {
    checkIfObjectFromAnotherCategory(object) {
      if (this.currentCategorySlug !== object.type) {
        this.$router.push({ name: object.type });
        setTimeout(() => {
          this.chooseObject(object);
        }, 0);
        return true;
      }
      return false;
    },
    chooseObject(object) {
      if (this.checkIfObjectFromAnotherCategory(object)) return;
      this.$store.commit('main/filterReset');
      this.$store.commit('main/switchFavoritesState', false);
      this.$store.commit('main/changeCurrentObject', object);
      if (this.objectInfoVisibility[object.id].fullInfo) {
        this.$router.push({ name: this.currentCategorySlug, params: { objectId: object.id.toString() } });
      } else {
        this.$store.commit('main/toggleBlocksVisibility', {
          block: 'ObjectBlock',
          visible: true,
        });
      }
      if (this.objectInfoVisibility[object.id].fullInfo) {
        this.$store.commit('main/showObjectAtMap', object.coordinates);
      }
    },
    closeDropdown() {
      this.opacity = 0;
      setTimeout(() => {
        $(this.$refs.searchDropdown).dropdown('hide');
      }, 500);
    },
    focusInput() {
      if (this.foundedObjects.length || this.text.length >= this.minSearchStringLength) {
        $(this.$refs.searchDropdown).dropdown('show');
      }
      this.opacity = 1;
    },
    clearForm() {
      this.text = '';
    },
  },
};
</script>
