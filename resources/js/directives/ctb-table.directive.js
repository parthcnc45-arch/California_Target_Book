
import Vue from 'vue';

import 'datatables.net';

const defaultSettings = {
  paging: false,
};

export default Vue.directive('ctb-table', {
  bind(el, binding, vnode) {
    console.log(binding);

    const settings = Object.assign({}, defaultSettings, binding.value);
    window.jQuery(el).DataTable(settings);

  },

  update(el, binding) {
    const dt = $(el).dataTable().api();

    if (dt.data().count() !== binding.value.data.length) {
      dt.clear();
      dt.rows.add(binding.value.data);
      dt.draw();
    }

    dt.search(binding.value.query).draw();
  },


});
