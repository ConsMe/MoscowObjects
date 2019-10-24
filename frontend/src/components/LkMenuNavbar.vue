<template>
  <li class="nav-item col-3 col-lg-auto dropdown">
    <a
      class="nav-link dropdown-toggle"
      href="/"
      id="lkDropdown"
      role="button"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
    >
      Кабинет
      <i class="fa fa-user ml-2" :class="{'text-primary': isAuthorized}"></i>
    </a>
    <div class="dropdown-menu w-auto lk-menu" aria-labelledby="lkDropdown">
      <template v-if="['admin', 'manager'].includes(user.role)">
        <router-link
            class="dropdown-item"
            :to="{name: 'lk-object', params: {id: 'new'}}">
            Новый объект
        </router-link>
        <router-link
            class="dropdown-item"
            :to="{name: 'lk-objects'}">
            Каталог
        </router-link>
      </template>
      <router-link
        class="dropdown-item"
        :to="{name: 'lk-users'}"
        v-if="user.role === 'admin'">
        Пользователи
      </router-link>
      <router-link
        class="dropdown-item"
        :to="{name: 'lk-login'}"
        v-if="!isAuthorized">
        Войти
      </router-link>
      <template v-else>
        <router-link
          class="dropdown-item"
          :to="{name: 'lk-account'}">
          Аккаунт
        </router-link>
        <a class="dropdown-item" href @click.prevent="logout">Выйти</a>
        <form ref="logoutForm" action="/logout" method="POST" style="display: none;">
            <input type="hidden" name="_token" ref="csrf">
        </form>
      </template>
    </div>
  </li>
</template>

<style>
.lk-menu {
  min-width: 100% !important;
}
</style>

<script>
export default {
  name: 'LkMenuNavbar',
  computed: {
    isAuthorized() {
      return this.$store.state.isAuthorized;
    },
    user() {
      return this.$store.state.user;
    },
  },
  methods: {
    logout(e) {
      if (this.$route.name === 'main') e.stopPropagation();
      this.$refs.csrf.value = document.head.querySelector('meta[name=csrf-token]').getAttribute('content');
      this.$refs.logoutForm.submit();
    },
  },
};
</script>
