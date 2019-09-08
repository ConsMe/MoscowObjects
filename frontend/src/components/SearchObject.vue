<template>
  <li class="nav-item col col-auto dropdown">
    <form>
      <input
        class="form-control bg-transparent border-white text-white"
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
    >
      <template v-if="foundedObjects.length">
        <a
          v-for="(object, i) in foundedObjects"
          :key="object.id"
          class="dropdown-item text-truncate"
          href="/"
          :data-object-index="i"
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
        this.$store.commit('changeCurrentCategorySlug', object.type);
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
      this.$store.commit('main/toggleBlocksVisibility', {
        block: 'ObjectFullInfo',
        visible: true,
      });
      this.$store.commit('main/showObjectAtMap', object.coordinates);
    },
    closeDropdown(e) {
      if (e.relatedTarget && e.relatedTarget.hasAttribute('data-object-index')) {
        const index = e.relatedTarget.getAttribute('data-object-index');
        const object = this.foundedObjects[index];
        this.chooseObject(object);
      }
      $(this.$refs.searchDropdown).dropdown('hide');
    },
    focusInput() {
      if (this.foundedObjects.length || this.text.length >= this.minSearchStringLength) {
        $(this.$refs.searchDropdown).dropdown('show');
      }
    },
    clearForm() {
      this.text = '';
    },
  },
};
</script>
