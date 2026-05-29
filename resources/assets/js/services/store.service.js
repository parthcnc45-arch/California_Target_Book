
import store from 'store';

const prefix = 'ctb>';

export default {
  set(key, value) {
    return store.set(prefix + key, value);
  },
  get(key) {
    return store.get(prefix + key);
  },
  remove(key) {
    return store.remove(prefix + key);
  }
};
