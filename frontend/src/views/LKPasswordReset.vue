<template>
  <div class="wrap-register-block">
    <div
      :style="{paddingLeft: objectBlockWidth ? objectBlockWidth + 'px' : '1rem'}"
      class="mt-5 password-reset-block"
      :class="{'d-none': !isMobileDevice && !objectBlockWidth}">
      <div>
      <h5 class="text-primary mb-3">
        {{ token ? 'Сброс пароля' : 'Запрос на сброс пароля' }}
      </h5>
      <form @submit.prevent="reset">
        <div class="form-group">
          <label>Email</label>
          <input
            type="email"
            class="form-control border"
            v-model="email"
            required
            :class="{'is-invalid': errors.email}"
            autocomplete="email"
            autofocus
            :disabled="disabled"
            placeholder="name@domain.ru"
          />
          <span class="invalid-feedback" role="alert" v-if="errors.email">
            <strong>{{ errors.email[0] }}</strong>
          </span>
        </div>
        <div class="form-group" v-if="token">
          <label>Новый пароль</label>
          <input
            type="password"
            class="form-control border"
            v-model="password"
            autocomplete="new-password"
            required
            :class="{'is-invalid': errors.password}"
            placeholder="••••••••••"
          />

          <span class="invalid-feedback" role="alert" v-if="errors.password">
            <strong>{{ errors.password[0] }}</strong>
          </span>
        </div>
        <div class="form-group" v-if="token">
          <label>Подтверждение пароля</label>
          <input
            type="password"
            class="form-control border"
            v-model="password_confirmation"
            autocomplete="new-password"
            required
            :class="{'is-invalid': errors.password_confirmation}"
            placeholder="••••••••••"
          />
          <span class="invalid-feedback" role="alert" v-if="errors.password_confirmation">
            <strong>{{ errors.password_confirmation[0] }}</strong>
          </span>
        </div>
        <div class="mt-4">
          <button
            type="submit"
            class="btn btn-primary mr-1"
            :disabled="disabled">
            {{ token ? 'Сбросить пароль' : 'Отправить' }}
          </button>
          <button
            type="button"
            class="btn btn-secondary ml-1"
            :disabled="disabled"
            @click="$router.push({name: 'lk-login'})">
             Отмена
          </button>
        </div>
        <p v-if="emailSent" class="font-italic mt-3">
          На Ваш email отправлена ссылка для сброса пароля
        </p>
        <p v-if="errors.token" class="font-italic mt-3">
          Срок действия ссылки истек.
          <router-link :to="{name: 'lk-password-reset'}">Отправить новую</router-link>
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
.password-reset-block {
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

export default {
  name: 'LKPasswordReset',
  data() {
    return {
      email: this.$route.query.email || '',
      errors: {},
      disabled: false,
      emailSent: undefined,
      token: this.$route.params.token,
      password: '',
      password_confirmation: '',
    };
  },
  beforeRouteUpdate(to, from, next) {
    this.email = to.query.email || '';
    this.errors = {};
    this.token = to.params.token;
    next();
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
    reset() {
      this.errors = {};
      this.disabled = true;
      if (!this.token) {
        this.sendLink();
      } else {
        this.setNewPassword();
      }
    },
    sendLink() {
      this.emailSent = undefined;
      Http.post('/password/email', { email: this.email })
        .then(() => {
          this.emailSent = true;
          this.email = '';
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
    setNewPassword() {
      Http.post('/password/reset', this.$data)
        .then((response) => {
          toastr.success('Ваш пароль был успешно изменен');
          this.$store.commit('changeAuthState', { isAuthorized: 1, user: response.data.user });
          this.$router.push({ name: 'lk-account' });
        })
        .catch((error) => {
          if (error.response && error.response.data.errors) {
            let { errors } = error.response.data;
            if (errors.email && errors.email[0] === 'token') {
              errors = { token: [true] };
            }
            this.errors = errors;
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
