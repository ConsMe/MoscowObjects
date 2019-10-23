<template>
  <div class="wrap-register-block">
    <div
      :style="{paddingLeft: objectBlockWidth ? objectBlockWidth + 'px' : '1rem'}"
      class="mt-4 login-block"
      :class="{'d-none': !isMobileDevice && !objectBlockWidth, 'mt-5' : !isMobileDevice}">
      <back-button />
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
              placeholder="name@domain.ru"
              autofocus
              autocomplete="email"
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
              placeholder="••••••••••"
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
          <p>
            Забыли пароль?
            <router-link :to="{name: 'lk-password-reset'}">Сбросить</router-link>
          </p>
        </form>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
@import "../assets/css/_variables.scss";

@media (max-width: 991.98px){
  .wrap-register-block {
    justify-content: center;
    display: flex;
    width: 100%;
  }
}
.login-block {
  width: 18rem;
  box-sizing: content-box;
  ::placeholder {
    color: $gray-400;
  }
}
</style>

<script>
import toastr from 'toastr';
import Http from '../modules/Http';
import BackButton from '../components/elements/BackButton.vue';

export default {
  name: 'LKLogin',
  components: { BackButton },
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
    isMobileDevice() {
      return this.$store.getters.isMobileDevice;
    },
  },
  methods: {
    login() {
      this.disabled = true;
      this.errors = {};
      console.log(4444);
      Http.post('/login', this.credentials)
        .then((response) => {
          console.log(555);
          console.log(this.$route);
          if (this.$route.query.url) {
            window.location.href = this.$route.query.url;
            return;
          }
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
