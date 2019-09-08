export default {
  namespaced: true,
  state: {
    isYmapReady: window.ymapsState,
  },
  mutations: {

  },
  getters: {
    roles() {
      return {
        admin: 'Администратор',
        manager: 'Менеджер',
        partner: 'Партнер',
      };
    },
  },
};
