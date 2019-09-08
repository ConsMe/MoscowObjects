<template>
  <div :style="{paddingLeft: objectBlockWidth + 'px'}" class="mt-5 register-block">
    <div>
    <h5 class="text-primary mb-3">
      Войти
    </h5>
    <form @submit.prevent="login">
      <div class="form-group">
        <label>Email</label>
        <input
          type="email"
          class="form-control border"
          v-model="credentials.email"
          required
          :class="{'is-invalid': errors.email}"
        />
        <span class="invalid-feedback" role="alert" v-if="errors.email">
          <strong>{{ errors.email[0] }}</strong>
        </span>
      </div>
      <div class="form-group">
        <label>Пароль</label>
        <input
          type="password"
          class="form-control border"
          v-model="credentials.password"
          required
          :class="{'is-invalid': errors.password}"
        />
        <span class="invalid-feedback" role="alert" v-if="errors.password">
          <strong>{{ errors.password[0] }}</strong>
        </span>
      </div>
      <button type="submit" class="btn btn-primary mt-3" :disabled="disabled">Войти</button>
      <p class="mb-0 mt-3">
        Нет аккаунта?
        <router-link :to="{name: 'lk-register'}">Зарегистрироваться</router-link>
      </p>
    </form>
    </div>
  </div>
</template>

<style lang="scss">
.register-block {
  width: 18rem;
  box-sizing: content-box;
}
</style>

<script>
import toastr from 'toastr';
import Http from '../modules/Http';

export default {
  name: 'LKLogin',
  data() {
    return {
      credentials: {
        email: '',
        password: '',
      },
      errors: {},
      disabled: false,
    };
  },
  computed: {
    objectBlockWidth() {
      return this.$store.state.objectBlockWidth;
    },
  },
  methods: {
    login() {
      this.disabled = true;
      Http.post('/login', this.credentials)
        .then((response) => {
          this.$store.commit('changeAuthState', { isAuthorized: 1, user: response.data.user });
          this.$router.push({ name: 'lk-account' });
        })
        .catch((error) => {
          if (error.response && error.response.data.errors) {
            this.errors = error.response.data.errors;
            return;
          }
          toastr.warning('Что-то пошло не так, попробуйте позднее');
        })
        .finally(() => {
          this.disabled = false;
        });
    },
  },
};
</script>
