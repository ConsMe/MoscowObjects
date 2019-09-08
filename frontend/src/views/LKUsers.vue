<template>
  <div :style="{paddingLeft: objectBlockWidth + 'px'}" class="mt-5 users-block">
    <h5 class="text-primary mb-5">Пользователи</h5>
    <div class="row pb-5">
      <div class="col">
        <table class="table table-hover m-0 sticky-thead">
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Имя</th>
              <th scope="col">Email</th>
              <th scope="col" class="text-center">Доступ</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr class="bg-white" v-for="(user, i) in users" :key="user.id">
              <td>{{ i + 1 }}</td>
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td class="text-center">
                <select v-if="!user.deleted_at"
                  class="text-lowercase custom-select w-auto pb-0 pt-0"
                  @change="setRole(user.id, i, $event)"
                >
                  <option value :selected="!user.role" v-if="!user.role">Не установлено</option>
                  <option value="admin" :selected="user.role === 'admin'">{{ roles['admin'] }}</option>
                  <option value="manager" :selected="user.role === 'manager'">{{ roles['manager'] }}</option>
                  <option value="partner" :selected="user.role === 'partner'">{{ roles['partner'] }}</option>
                </select>
              </td>
              <td v-if="!user.deleted_at" class="text-center">
                <button class="btn btn-sm btn-outline-danger" @click="deleteUser(user, i)">удалить</button>
              </td>
              <td v-else class="text-center">
                <button class="btn btn-sm btn-outline-primary" @click="restoreUser(user, i)">восстановить</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
@import "../assets/css/_variables.scss";

.users-block {
  font-size: 1rem;
  .custom-control-label {
    cursor: pointer;
  }
  select {
    font-size: 1rem;
    color: $gray-500;
    height: initial;
  }
  td {
    padding: 0.5rem;
  }
  .custom-select:focus {
    border-color: transparent;
    box-shadow: none;
  }
  .sticky-thead tr > th {
    position: sticky;
    top: -1px;
    z-index: 1;
  }
}
</style>

<script>
import toastr from '../components/elements/toastr';
import Http from '../modules/Http';

toastr.options.preventDuplicates = false;

export default {
  name: 'LKUsers',
  data() {
    return {
      users: [],
    };
  },
  computed: {
    objectBlockWidth() {
      return this.$store.state.objectBlockWidth;
    },
    roles() {
      return this.$store.getters['lk/roles'];
    },
  },
  created() {
    Http.get('/users')
      .then((response) => {
        this.users = response.data;
      })
      .catch(() => toastr.warning('Что-то пошло не так, попробуйте позднее'));
  },
  methods: {
    setRole(id, index, event) {
      const role = event.target.value;
      Http.post(`/users/${id}`, null, { params: { _method: 'PUT', role } })
        .then(() => {
          this.users[index].role = role;
          toastr.success('Роль пользователя успешно изменена');
        })
        .catch(() => toastr.warning('Что-то пошло не так, попробуйте позднее'));
    },
    deleteUser(user, index) {
      Http.post(`/users/${user.id}`, null, { params: { _method: 'DELETE' } })
        .then(() => {
          this.users[index].deleted_at = true;
          toastr.success('Пользователь удален');
        })
        .catch(() => toastr.warning('Что-то пошло не так, попробуйте позднее'));
    },
    restoreUser(user, index) {
      Http.post(`/users/${user.id}/restore`)
        .then(() => {
          this.users[index].deleted_at = null;
          toastr.success('Пользователь восстановлен');
        })
        .catch(() => toastr.warning('Что-то пошло не так, попробуйте позднее'));
    },
  },
};
</script>
