<template>
  <div :style="{paddingLeft: objectBlockWidth + 'px'}" class="mt-5 register-block">
    <div>
    <h5 class="text-primary mb-3">Регистрация</h5>
    <form autocomplete="off" @submit.prevent="register">
      <div class="form-group">
        <label>Ваше Имя</label>
        <input
          type="text"
          class="form-control border"
          v-model="credentials.name"
          required
          :class="{'is-invalid': errors.name}"
        />
        <span class="invalid-feedback" role="alert" v-if="errors.name">
          <strong>{{ errors.name[0] }}</strong>
        </span>
      </div>
      <div class="form-group">
        <label>Ваш Email</label>
        <input
          type="email"
          class="form-control border"
          v-model="credentials.email"
          autocomplete="off"
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
          autocomplete="new-password"
          required
          :class="{'is-invalid': errors.password}"
        />

        <span class="invalid-feedback" role="alert" v-if="errors.password">
          <strong>{{ errors.password[0] }}</strong>
        </span>
      </div>
      <div class="form-group">
        <label>Подтверждение пароля</label>
        <input
          type="password"
          class="form-control border"
          v-model="credentials.password_confirmation"
          autocomplete="new-password"
          required
          :class="{'is-invalid': errors.password_confirmation}"
        />
        <span class="invalid-feedback" role="alert" v-if="errors.password_confirmation">
          <strong>{{ errors.password_confirmation[0] }}</strong>
        </span>
      </div>
      <button type="submit" class="btn btn-primary mt-3" :disabled="disabled">Регистрация</button>
      <p class="mb-0 mt-3">
        Есть аккаунт?
        <router-link :to="{name: 'lk-login'}">Войти</router-link>
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
  name: 'LKRegister',
  data() {
    return {
      credentials: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
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
    register() {
      this.disabled = true;
      Http.post('/register', this.credentials)
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
