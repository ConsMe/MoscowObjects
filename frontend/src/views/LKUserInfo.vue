<template>
  <div :style="{paddingLeft: objectBlockWidth + 'px'}" class="mt-5">
    <h5 class="text-primary mb-5">Личный кабинет пользователя</h5>
    <div class="row">
      <div class="col col-auto">
        <p>Пользователь:</p>
        <p>E-mail:</p>
        <p>Доступ:</p>
        <p>Последнее посещение:</p>
        <p>Новых объектов:</p>
        <p>Подписка на новые объекты:</p>
      </div>
      <div class="col col-auto">
        <p>{{ user.name }}</p>
        <p>{{ user.email }}</p>
        <p>{{ roles[user.role] ? roles[user.role] : '&minus;' }}</p>
        <p v-if="last_login">{{ last_login }}</p>
        <p v-else>&minus;</p>
        <p>0</p>
        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input
              type="checkbox"
              class="custom-control-input"
              :checked="user.subscribed"
              id="subscribed"
              :disabled="disabled"
              @click.prevent="changeSubscriptionStatus"
            />
            <label class="custom-control-label" for="subscribed"></label>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-4 font-italic text-secondary" v-if="!user.email_verified_at">
        <p>Вам необходимо подтвердить свой email</p>
        <p>
          Не получили письмо?
          <a href="" @click.stop.prevent="sendEmail">
            Отправить еще раз
          </a>
        </p>
    </div>
    <p class="mt-4 font-italic text-secondary" v-else-if="!user.accepted">
        Ваш аккаунт ожидает подтверждения администратором
    </p>
    <div class="row mt-4" v-else>
      <div class="col col-auto">
        <div class="row mb-2" v-if="hasCatalogAccess">
          <div class="col">
            <router-link
              :to="{name: 'lk-object', params: {id: 'new'}}"
              class="btn btn-primary btn-block"
            >Разместить новый объект</router-link>
          </div>
        </div>
        <div class="row mb-2" v-if="hasCatalogAccess">
          <div class="col">
            <router-link
              :to="{name: 'lk-objects'}"
              class="btn btn-secondary btn-block"
            >Управление каталогом</router-link>
          </div>
        </div>
        <div class="row mb-2" v-if="user.role === 'admin'">
          <div class="col">
            <router-link
              :to="{name: 'lk-users'}"
              class="btn btn-outline-secondary btn-block"
            >Пользователи</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.mt-5 {
  font-size: 1rem;
}
.custom-control-label {
  cursor: pointer;
}
</style>

<script>
import moment from 'moment';
import toastr from '../components/elements/toastr';
import Http from '../modules/Http';

export default {
  name: 'LKUserInfo',
  data() {
    return {
      disabled: false,
    };
  },
  computed: {
    objectBlockWidth() {
      return this.$store.state.objectBlockWidth;
    },
    user() {
      return this.$store.state.user;
    },
    roles() {
      return this.$store.getters['lk/roles'];
    },
    last_login() {
      return this.user.last_login ? moment(this.user.last_login).format('DD.MM.YYYY') : null;
    },
    hasCatalogAccess() {
      return ['admin', 'manager'].includes(this.user.role);
    },
  },
  methods: {
    changeSubscriptionStatus() {
      this.disabled = true;
      const status = !this.user.subscribed;
      Http.post('/changeSubscriptionStatus', { status })
        .then(() => {
          this.$store.commit('changeSubscriptionStatus', status);
        })
        .catch(() => {
          toastr.warning('Что-то пошло не так, попробуйте позднее');
        })
        .finally(() => {
          this.disabled = false;
        });
    },
    sendEmail() {
      if (this.disabled) return;
      this.disabled = true;
      Http.get('email/resend').then(() => {
        toastr.success('Вам отправлено повторное письмо');
      }).finally(() => {
        this.disabled = false;
      });
    },
  },
};
</script>
