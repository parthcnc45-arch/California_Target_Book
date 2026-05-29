
// Vendor
window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('bootstrap');
require('jquery-ui-dist/jquery-ui.min.js');

require('smartmenus');
require('tablesaw/dist/tablesaw.jquery.js');
require('tablesaw/dist/tablesaw-init.js');

/**
 * Non Vue js
 */
require('./nav');
require('./dist-side-nav');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');
let apiToken = document.head.querySelector('meta[name="api_token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
if (apiToken) {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${apiToken.content}`;
}


// For hot reloads
if (module.hot) {
  const link = document.getElementById('appStyles');
  if (link) {
    const appStylesHref = link.href;
    module.hot.addStatusHandler(status => {
      console.log(status);
      if (status === 'apply') {
        appStyles.href = appStylesHref + `?d=${new Date()}`
      }
    });
  }
}