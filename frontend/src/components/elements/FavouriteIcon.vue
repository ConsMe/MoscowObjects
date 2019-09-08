<template>
  <i
    class="fa text-danger"
    :class="[isFavouriteIcon]"
    @click.stop="toggleFavourite"
  ></i>
</template>

<script>
import Http from '../../modules/Http';
import toastr from './toastr';

export default {
  name: 'FavouriteIcon',
  props: ['objectId'],
  data() {
    return {
      disabled: false,
    };
  },
  computed: {
    favourites() {
      return this.$store.state.main.favourites;
    },
    isFavourite() {
      return this.favourites.includes(this.objectId);
    },
    isFavouriteIcon() {
      return this.isFavourite ? 'fa-heart' : 'fa-heart-o';
    },
    isAuthorized() {
      return this.$store.state.isAuthorized;
    },
  },
  methods: {
    toggleFavourite() {
      if (this.isAuthorized) {
        this.authFavorite();
      } else {
        this.dispatchFavourite();
      }
    },
    authFavorite() {
      if (this.disabled) return;
      this.disabled = true;
      const params = { method: 'post', url: `/favourites/${this.objectId}` };
      if (this.isFavourite) {
        params.url += '?_method=DELETE';
      }
      Http.request(params).then(() => {
        this.dispatchFavourite();
      }).catch(() => {
        toastr.warning('Что пошло не так, попробуйте позднее');
      }).finally(() => {
        this.disabled = false;
      });
    },
    dispatchFavourite() {
      this.$store.dispatch('main/toggleObjectFavourite', { id: this.objectId, value: !this.isFavourite });
    },
  },
};
</script>
