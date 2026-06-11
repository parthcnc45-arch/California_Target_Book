/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

console.log('Starting Vue.');

import Vue from 'vue';
Vue.config.devtools = true;
import Raven from 'raven-js';
import RavenVue from 'raven-js/plugins/vue';

console.log('Vue Imported.');

if (window.globals && window.globals.ENV !== 'production') {
  Raven
      .config('https://4cb8e52ea3dc4447a5590bc0e846f308@sentry.io/305883', {
        environment: window.globals && window.globals.ENV,
        release: window.globals && window.globals.RELEASE,
      })
      .addPlugin(RavenVue, Vue)
      .install();
}

if (window.user) {
  console.log('IDentified window.user');
  Raven.setUserContext({
    id: window.user.id,
    email: window.user.email,
  });
}

console.log('Importing bootstrap');
require('./bootstrap');

console.log('Initializing Vue instance');

window.Vue = Vue;
require('./filters');
//require('laravel-vue-whoops');

console.log('Loaded filters, Whoops debug bar');

import './directives/ctb-table.directive';
import './directives/radio-tabs.directive';

console.log('Imported directives');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

console.log('Loading Vue components from ./components/ directory');



Vue.component('ctb-head-nav', require('./components/Navbar.vue').default);
console.log('Loaded ctb-head-nav');

Vue.component('ctb-book-side-nav', require('./components/BookSideNav.vue').default);
console.log('Loaded ctb-book-side-nav. Here comes the pain...');





Vue.component('ctb-register', require('./components/RegisterComponent.vue').default);
console.log('Loaded ctb-register');

//Vue.component('stripe-bank-element', require('./components/StripeBankElementComponent.vue').default);
console.log('Loaded stripe-bank-element');

//Vue.component('stripe-element', require('./components/StripeElementComponent.vue').default);
console.log('Loaded stripe-element');

Vue.component('ctb-event-signup', require('./components/EventSignupComponent.vue').default);
Vue.component('ctb-renew', require('./components/RenewComponent.vue').default);
console.log('Loaded ctb-renew');

Vue.component('ctb-house-cand-directory', require('./book/candidates/house-cand-directory.vue').default);
console.log('Loaded ctb-house-cand-directory');

Vue.component('change-password-modal', require('./components/modals/ChangePasswordModal.vue').default);
Vue.component('account-info-form', require('./components/AccountInfoForm.vue').default);
console.log('Loaded change-password-modal');

Vue.component('feedback-modal', require('./components/modals/FeedbackModal.vue').default);
console.log('Loaded feedback-modal');

Vue.component('send-message-modal', require('./components/modals/SendMessageModal.vue').default);
console.log('Loaded send-message-modal');

Vue.component('invoice-modal', require('./components/modals/InvoiceModal.vue').default);
console.log('Loaded invoice-modal');

Vue.component('verify-bank-modal', require('./components/modals/VerifyBankModal.vue').default);
console.log('Loaded verify-bank-modal');

Vue.component('ctb-loader', require('./components/loader.vue').default);
console.log('Loaded ctb-loader');

Vue.component('ctb-address-block', require('./components/AddressBlock.vue').default);
console.log('Loaded ctb-address-block');

Vue.component('ctb-payment-block', require('./components/PaymentBlock.vue').default);
console.log('Loaded ctb-payment-block');


console.log('Vue components loaded. Initializing App.');

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

console.log('Vue JS finished loading.');
