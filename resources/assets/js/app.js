/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import Raven from 'raven-js';
import RavenVue from 'raven-js/plugins/vue';


if (window.globals.ENV !== 'production') {
  Raven
      .config('https://4cb8e52ea3dc4447a5590bc0e846f308@sentry.io/305883', {
        environment: window.globals && window.globals.ENV,
        release: window.globals && window.globals.RELEASE,
      })
      .addPlugin(RavenVue, Vue)
      .install();
}

if (window.user) {
  Raven.setUserContext({
    id: window.user.id,
    email: window.user.email,
  });
}

require('./bootstrap');
window.Vue = Vue;
require('./filters');

import './directives/ctb-table.directive';
import './directives/radio-tabs.directive';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('ctb-head-nav', require('./components/Navbar.vue'));
Vue.component('ctb-book-side-nav', require('./components/BookSideNav.vue'));
Vue.component('stripe-element', require('./components/StripeElementComponent.vue'));
Vue.component('stripe-bank-element', require('./components/StripeBankElementComponent.vue'));
Vue.component('ctb-register', require('./components/RegisterComponent.vue'));
Vue.component('ctb-event-signup', require('./components/EventSignupComponent.vue'));
Vue.component('ctb-renew', require('./components/RenewComponent.vue'));

Vue.component('ctb-house-cand-directory', require('./book/candidates/house-cand-directory.vue'));

Vue.component('change-password-modal', require('./components/modals/ChangePasswordModal.vue'));
Vue.component('feedback-modal', require('./components/modals/FeedbackModal.vue'));
Vue.component('send-message-modal', require('./components/modals/SendMessageModal.vue'));
Vue.component('invoice-modal', require('./components/modals/InvoiceModal.vue'));
Vue.component('verify-bank-modal', require('./components/modals/VerifyBankModal.vue'));
Vue.component('ctb-loader', require('./components/loader.vue'));
Vue.component('ctb-address-block', require('./components/AddressBlock.vue'));
Vue.component('ctb-payment-block', require('./components/PaymentBlock.vue'));


const app = new Vue({
  el: '#app',
  data() {
    return {
      showInvoiceModal: false,
      showFeedbackModal: false,
      showChangePasswordModal: false,
      showVerifyBankModal: false,
      sendMessageModalTo: null,
    }
  },
  methods: {
    openBookNav(nav) {
      this.$refs.bookSideNav.setNav(nav);
    }
  }
});
