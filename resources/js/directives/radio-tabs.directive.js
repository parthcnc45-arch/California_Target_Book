
import Vue from 'vue';

export default Vue.directive('ctb-radio-tabs', {
  bind(el, binding, vnode) {
    const $el = window.jQuery(el);

    $el.find('label')
        .on('click', function (e) {
          $el.find('label').removeClass('active');
          $el.find('input').attr('checked', false);

          const $this = window.jQuery(this);
          $this.addClass('active');
          $this.find('input').attr('checked', true);

          $el.find('input').trigger('change');
        });
  }
});
