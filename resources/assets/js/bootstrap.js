
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

window.axios = require('./api').default;


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