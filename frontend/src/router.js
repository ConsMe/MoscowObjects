import Vue from 'vue';
import Router from 'vue-router';
import store from './store';

Vue.use(Router);

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '*',
      redirect: { name: 'ZU' },
    },
    {
      path: '/zu/:objectId(\\d+)?',
      name: 'ZU',
      component: () => import('./views/Main.vue'),
    },
    {
      path: '/invest/:objectId(\\d+)?',
      name: 'Invest',
      component: () => import('./views/Main.vue'),
    },
    {
      path: '/lk',
      name: 'lk',
      component: () => import('./views/LK.vue'),
      redirect: { name: 'lk-account' },
      children: [
        {
          path: 'objects',
          name: 'lk-objects',
          component: () => import('./views/LKList.vue'),
        },
        {
          path: 'register',
          name: 'lk-register',
          component: () => import('./views/LKRegister.vue'),
        },
        {
          path: 'login',
          name: 'lk-login',
          component: () => import('./views/LKLogin.vue'),
        },
        {
          path: 'password/reset/:token?',
          name: 'lk-password-reset',
          component: () => import('./views/LKPasswordReset.vue'),
        },
        {
          path: 'account',
          name: 'lk-account',
          component: () => import('./views/LKUserInfo.vue'),
        },
        {
          path: 'objects/:id',
          name: 'lk-object',
          component: () => import('./views/LKObject.vue'),
        },
        {
          path: 'users',
          name: 'lk-users',
          component: () => import('./views/LKUsers.vue'),
        },
      ],
    },
  ],
});

router.beforeResolve((to, from, next) => {
  if (['lk-login', 'lk-register', 'lk-password-reset'].includes(to.name)) {
    if (store.state.isAuthorized) {
      next({ name: 'lk-account' });
      return;
    }
  }
  if (['lk-users', 'lk-object', 'lk-objects'].includes(to.name)) {
    if (!store.state.isAccepted) {
      next({ name: 'lk-account' });
      return;
    }
  }
  if (['lk-account'].includes(to.name)) {
    if (!store.state.isAuthorized) {
      next({ name: 'lk-login' });
      return;
    }
  }
  next();
});


export default router;
