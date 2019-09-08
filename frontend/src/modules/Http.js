import axios from 'axios';

const baseURL = window.location.origin;

const headers = {
  'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').getAttribute('content'),
  'X-Requested-With': 'XMLHttpRequest',
};

const Parent = axios.create({
  baseURL,
  headers,
});

function setToken(token) {
  Parent.defaults.headers['X-CSRF-TOKEN'] = token;
  document.querySelector('meta[name=csrf-token]').setAttribute('content', token);
}

Parent.interceptors.response.use((response) => {
  if (response.headers && response.headers['new-token']) {
    if (response.headers['new-token'].length) {
      setToken(response.headers['new-token']);
    }
  }
  return response;
}, error => Promise.reject(error));

function refreshAppTokens() {
  Parent.get('/')
    .then(({ data }) => {
      const wrapper = document.createElement('div');
      wrapper.innerHTML = data;
      return wrapper.querySelector('meta[name=csrf-token]').getAttribute('content');
    })
    .then((token) => {
      setToken(token);
    });
}

setInterval(refreshAppTokens, 1000 * 60 * 50);

class Http extends Parent { }

export default Http;

export const { CancelToken, isCancel } = axios;
