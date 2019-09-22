<template>
  <div class="wrap-register-block">
    <div
      :style="{paddingLeft: objectBlockWidth ? objectBlockWidth + 'px' : '1rem'}"
      class="mt-5 register-block"
      :class="{'d-none': !isMobileDevice && !objectBlockWidth}">
      <div>
      <h5 class="text-primary mb-3">Регистрация</h5>
      <form autocomplete="off" @submit.prevent="register" class="mb-5">
        <div class="form-group">
          <label>ФИО</label>
          <input
            type="text"
            class="form-control border"
            v-model="credentials.name"
            required
            :class="{'is-invalid': errors.name}"
            placeholder="Фамилия Имя Отчество"
          />
          <span class="invalid-feedback" role="alert" v-if="errors.name">
            <strong>{{ errors.name[0] }}</strong>
          </span>
        </div>
        <div class="form-group">
          <label>Компания</label>
          <input
            type="text"
            class="form-control border"
            v-model="credentials.company"
            required
            :class="{'is-invalid': errors.company}"
            placeholder="Наименование компании"
          />
          <span class="invalid-feedback" role="alert" v-if="errors.company">
            <strong>{{ errors.company[0] }}</strong>
          </span>
        </div>
        <div class="form-group">
          <label>Телефон</label>
          <input
            type="text"
            class="form-control border"
            v-model="credentials.tel"
            required
            :class="{'is-invalid': errors.tel}"
            placeholder="+7ХХХХХХХХХХ"
          />
          <span class="invalid-feedback" role="alert" v-if="errors.tel">
            <strong>{{ errors.tel[0] }}</strong>
          </span>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input
            type="email"
            class="form-control border"
            v-model="credentials.email"
            autocomplete="off"
            required
            :class="{'is-invalid': errors.email}"
            placeholder="name@domain.ru"
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
            placeholder="••••••••••"
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
            placeholder="••••••••••"
          />
          <span class="invalid-feedback" role="alert" v-if="errors.password_confirmation">
            <strong>{{ errors.password_confirmation[0] }}</strong>
          </span>
        </div>
        <button type="submit" class="btn btn-primary mt-3" :disabled="disabled">Регистрация</button>
        <p class="mb-0 mt-2">
          Нажимая кнопку "Регистрация" вы соглашаетесь с
          <a href="/policy" target="_blank">Политикой конфиденциальности</a>
        </p>
        <p class="mb-0 mt-3">
          Есть аккаунт?
          <router-link :to="{name: 'lk-login'}">Войти</router-link>
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
.register-block {
  width: 20rem;
  box-sizing: content-box;
  ::placeholder {
    color: $gray-400;
  }
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
        company: '',
        tel: '',
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
    isMobileDevice() {
      return this.$store.getters.isMobileDevice;
    },
  },
  methods: {
    register() {
      this.disabled = true;
      this.errors = {};
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
