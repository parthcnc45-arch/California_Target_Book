webpackJsonp(["user-create.module"],{

/***/ "../../../../../resources/assets/admin/app/users/user-create/user-create.component.html":
/***/ (function(module, exports) {

module.exports = "\n<div class=\"row page-heading\">\n  <h1>Add Subscriber</h1>\n</div>\n\n\n<div class=\"\">\n  <form class=\"form\"\n    action=\"javascript:void(0)\"\n    [formGroup]=\"subscriberForm\"\n    novalidate\n    (submit)=\"onSubmit(subscriberForm)\">\n\n    <div class=\"row\">\n      <div class=\"ctb-title\">\n        <h5>Account Info</h5>\n      </div>\n      <div class=\"card-panel col m12 pt-md\">\n        <div class=\"row\">\n          <div class=\"input-field col m6\">\n            <label for=\"first_name\">First Name</label>\n            <input id=\"first_name\"\n                formControlName=\"first_name\"\n                required\n                [ngClass]=\"{'valid': isValid('first_name'), 'invalid': isInvalid('first_name')}\"\n                type=\"text\" />\n\n            <div *ngIf=\"get('first_name').errors && isInvalid('first_name')\">\n              <p class=\"error\" *ngIf=\"get('first_name').errors.required\">This field is required.</p>\n              <p class=\"error\" *ngIf=\"get('first_name').errors.server\" [innerHtml]=\"get('first_name').errors.server.join('<br/>')\"></p>\n            </div>\n          </div>\n\n          <div class=\"input-field col m6\">\n            <label for=\"last_name\">Last Name</label>\n            <input id=\"last_name\"\n                formControlName=\"last_name\"\n                required\n                [ngClass]=\"{'valid': isValid('last_name'), 'invalid': isInvalid('last_name')}\"\n                type=\"text\" />\n\n            <div *ngIf=\"get('last_name').errors && isInvalid('last_name')\">\n              <p class=\"error\" *ngIf=\"get('last_name').errors.server\" [innerHtml]=\"get('last_name').errors.server.join('<br/>')\"></p>\n              <p class=\"error\" *ngIf=\"get('last_name').errors.required\">This field is required.</p>\n            </div>\n          </div>\n\n          <div class=\"input-field col m6 clear\">\n            <label for=\"email\">Email</label>\n            <input id=\"email\"\n                formControlName=\"email\"\n                required\n                [ngClass]=\"{'valid': isValid('email'), 'invalid': isInvalid('email')}\"\n                type=\"email\" />\n\n            <div *ngIf=\"get('email').errors && isInvalid('email')\">\n              <p class=\"error\" *ngIf=\"get('email').errors.required\">This field is required.</p>\n              <p class=\"error\" *ngIf=\"get('email').errors.email\">Email is not Valid</p>\n              <p class=\"error\" *ngIf=\"get('email').errors.server\" [innerHtml]=\"get('email').errors.server.join('<br/>')\"></p>\n            </div>\n\n          </div>\n\n\n          <div class=\"input-field col m6\">\n            <label for=\"last_name\">Phone Number</label>\n            <input id=\"phone_number\"\n                formControlName=\"phone_number\"\n                maxlength=\"10\"\n                [ngClass]=\"{'valid': isValid('phone_number'), 'invalid': isInvalid('phone_number')}\"\n                type=\"text\" />\n\n            <div *ngIf=\"get('phone_number').errors && isInvalid('phone_number')\">\n              <p class=\"error\" *ngIf=\"get('phone_number').errors.server\" [innerHtml]=\"get('phone_number').errors.server.join('<br/>')\"></p>\n            </div>\n          </div>\n\n\n        </div>\n\n      </div>\n    </div>\n\n    <div class=\"row\">\n      <div class=\"ctb-title\">\n        <h5>Organization</h5>\n      </div>\n      <div class=\"card-panel col m12 pt-md\" formGroupName=\"company\">\n        <div class=\"row\">\n          <div class=\"input-field col m12\">\n            <label for=\"company\">Organization</label>\n            <input id=\"company\"\n                formControlName=\"name\"\n                [ngClass]=\"{'valid': isValid('company.name'), 'invalid': isInvalid('company.name')}\"\n                type=\"text\" />\n\n            <div *ngIf=\"get('company.name').errors && isInvalid('company.name')\">\n              <p class=\"error\" *ngIf=\"get('company.name').errors.server\" [innerHtml]=\"get('company.name').errors.server.join('<br/>')\"></p>\n            </div>\n          </div>\n\n          <div formGroupName=\"address\">\n            <div class=\"input-field col m6\">\n              <label for=\"company_address_line1\">Address Line 1</label>\n              <input id=\"company_address_line1\"\n                  formControlName=\"line1\"\n                  required\n                  type=\"text\" />\n\n              <div *ngIf=\"get('company.address.line1').errors && isInvalid(get('company.address.line1'))\">\n                <p class=\"error\" *ngIf=\"get('company.address.line1').errors.server\" [innerHtml]=\"get('company.address.line1').errors.server.join('<br/>')\"></p>\n                <p class=\"error\" *ngIf=\"get('company.address.line1').errors.required\">This field is required.</p>\n              </div>\n            </div>\n\n            <div class=\"input-field col m6\">\n              <label for=\"company_address_line2\">Address Line 2</label>\n              <input id=\"company_address_line2\"\n                  formControlName=\"line2\"\n                  type=\"text\" />\n            </div>\n\n            <div class=\"input-field col m4 clear\">\n              <label for=\"company_city\">City</label>\n              <input id=\"company_city\"\n                  formControlName=\"city\"\n                  required\n                  type=\"text\" />\n\n              <div *ngIf=\"get('company.address.city').errors && isInvalid(get('company.address.city'))\">\n                <p class=\"error\" *ngIf=\"get('company.address.city').errors.server\" [innerHtml]=\"get('company.address.city').errors.server.join('<br/>')\"></p>\n                <p class=\"error\" *ngIf=\"get('company.address.city').errors.required\">This field is required.</p>\n              </div>\n            </div>\n\n            <div class=\" col m4\">\n              <label for=\"company_state\">State</label>\n              <select id=\"company_state\"\n                  class=\"browser-default block\"\n                  formControlName=\"state\"\n                  required>\n\n                <option value=\"AL\">Alabama</option>\n                <option value=\"AK\">Alaska</option>\n                <option value=\"AZ\">Arizona</option>\n                <option value=\"AR\">Arkansas</option>\n                <option value=\"CA\" selected>California</option>\n                <option value=\"CO\">Colorado</option>\n                <option value=\"CT\">Connecticut</option>\n                <option value=\"DE\">Delaware</option>\n                <option value=\"DC\">District Of Columbia</option>\n                <option value=\"FL\">Florida</option>\n                <option value=\"GA\">Georgia</option>\n                <option value=\"HI\">Hawaii</option>\n                <option value=\"ID\">Idaho</option>\n                <option value=\"IL\">Illinois</option>\n                <option value=\"IN\">Indiana</option>\n                <option value=\"IA\">Iowa</option>\n                <option value=\"KS\">Kansas</option>\n                <option value=\"KY\">Kentucky</option>\n                <option value=\"LA\">Louisiana</option>\n                <option value=\"ME\">Maine</option>\n                <option value=\"MD\">Maryland</option>\n                <option value=\"MA\">Massachusetts</option>\n                <option value=\"MI\">Michigan</option>\n                <option value=\"MN\">Minnesota</option>\n                <option value=\"MS\">Mississippi</option>\n                <option value=\"MO\">Missouri</option>\n                <option value=\"MT\">Montana</option>\n                <option value=\"NE\">Nebraska</option>\n                <option value=\"NV\">Nevada</option>\n                <option value=\"NH\">New Hampshire</option>\n                <option value=\"NJ\">New Jersey</option>\n                <option value=\"NM\">New Mexico</option>\n                <option value=\"NY\">New York</option>\n                <option value=\"NC\">North Carolina</option>\n                <option value=\"ND\">North Dakota</option>\n                <option value=\"OH\">Ohio</option>\n                <option value=\"OK\">Oklahoma</option>\n                <option value=\"OR\">Oregon</option>\n                <option value=\"PA\">Pennsylvania</option>\n                <option value=\"RI\">Rhode Island</option>\n                <option value=\"SC\">South Carolina</option>\n                <option value=\"SD\">South Dakota</option>\n                <option value=\"TN\">Tennessee</option>\n                <option value=\"TX\">Texas</option>\n                <option value=\"UT\">Utah</option>\n                <option value=\"VT\">Vermont</option>\n                <option value=\"VA\">Virginia</option>\n                <option value=\"WA\">Washington</option>\n                <option value=\"WV\">West Virginia</option>\n                <option value=\"WI\">Wisconsin</option>\n                <option value=\"WY\">Wyoming</option>\n\n              </select>\n\n              <div class=\"mt-md\" *ngIf=\"get('company.address.state').errors && isInvalid(get('company.address.state'))\">\n                <p class=\"error\" *ngIf=\"get('company.address.state').errors.server\" [innerHtml]=\"get('company.address.state').errors.server.join('<br/>')\"></p>\n                <p class=\"error\" *ngIf=\"get('company.address.state').errors.required\">This field is required.</p>\n              </div>\n            </div>\n\n            <div class=\"input-field col m4\">\n              <label for=\"company_zip_code\">Zip Code</label>\n              <input id=\"company_zip_code\"\n                  formControlName=\"zip_code\"\n                  required\n                  type=\"text\" />\n\n              <div *ngIf=\"get('company.address.zip_code').errors && isInvalid(get('company.address.zip_code'))\">\n                <p class=\"error\" *ngIf=\"get('company.address.zip_code').errors.server\" [innerHtml]=\"get('company.address.zip_code').errors.server.join('<br/>')\"></p>\n                <p class=\"error\" *ngIf=\"get('company.address.zip_code').errors.required\">This field is required.</p>\n              </div>\n            </div>\n\n          </div>\n        </div>\n      </div>\n    </div>\n\n    <div class=\"row\">\n      <div class=\"ctb-title\">\n        <h5>Subscription</h5>\n      </div>\n      <div class=\"card-panel col s12 pt-md\">\n\n        <div class=\"section row\">\n          <div class=\"ctb-title sm col s12\">\n            <h6>Length</h6>\n          </div>\n\n          <div class=\"col m6\">\n            <p>\n              <input id=\"freq12\"\n                required\n                value=\"12\"\n                formControlName=\"subscription_length\"\n                type=\"radio\" />\n              <label for=\"freq12\">12 Month Subscription</label>\n            </p>\n            <p>\n              <input id=\"freq24\"\n                required\n                value=\"24\"\n                formControlName=\"subscription_length\"\n                checked\n                type=\"radio\" />\n              <label for=\"freq24\">24 Month Subscription</label>\n            </p>\n\n            <div *ngIf=\"get('subscription_length').errors && isInvalid('subscription_length')\">\n              <p class=\"error\" *ngIf=\"get('subscription_length').errors.server\" [innerHtml]=\"get('subscription_length').errors.server.join('<br/>')\"></p>\n              <p class=\"error\" *ngIf=\"get('subscription_length').errors.required\">This field is required.</p>\n            </div>\n\n          </div>\n\n          <div class=\"col m6\">\n\n              <div class=\"input-field cost-field\">\n                <i class=\"material-icons prefix\">attach_money</i>\n                <input id=\"subscription_cost\"\n                  type=\"number\"\n                  formControlName=\"subscription_cost\"\n                  required\n                  min=\"0\"\n                  [ngClass]=\"{'valid': isValid('subscription_cost'), 'invalid': isInvalid('subscription_cost')}\" />\n                <label for=\"icon_prefix\" class=\"active\">Subscription Cost</label>\n\n                <div *ngIf=\"get('subscription_cost').errors && isInvalid('subscription_cost')\">\n                  <p class=\"error\" *ngIf=\"get('subscription_cost').errors.server\" [innerHtml]=\"get('subscription_cost').errors.server.join('<br/>')\"></p>\n                  <p class=\"error\" *ngIf=\"get('subscription_cost').errors.required\">This field is required.</p>\n                  <p class=\"error\" *ngIf=\"get('subscription_cost').errors.min\">Must be at least 0.</p>\n                </div>\n              </div>\n\n          </div>\n\n        </div>\n\n\n        <div class=\"section row\">\n          <div class=\"ctb-title sm col s12\">\n            <h6>Hard Copy Subscriptions</h6>\n          </div>\n\n          <div class=\"col m6\">\n            <div class=\"counter indigo lighten-1 mt-md\">\n              <span class=\"dec\" (click)=\"decrement('book_count')\">-</span>\n              <input type=\"text\"\n                formControlName=\"book_count\"\n                pattern=\"[0-9]+\"\n                required />\n              <span class=\"inc\" (click)=\"increment('book_count')\">+</span>\n            </div>\n            <div *ngIf=\"get('book_count').errors && isInvalid('book_count')\" class=\"mt-md\">\n              <p class=\"error\" *ngIf=\"get('book_count').errors.server\" [innerHtml]=\"get('book_count').errors.server.join('<br/>')\"></p>\n              <p class=\"error\" *ngIf=\"get('book_count').errors.required\">This field is required.</p>\n              <p class=\"error\" *ngIf=\"get('book_count').errors.min\">Must be at least 0.</p>\n            </div>\n          </div>\n\n          <div class=\"col m6\">\n\n              <div class=\"input-field cost-field\">\n                <i class=\"material-icons prefix\">attach_money</i>\n                <input id=\"book_cost\"\n                  type=\"number\"\n                  formControlName=\"book_cost\"\n                  required\n                  min=\"0\"\n                  [ngClass]=\"{'valid': isValid('book_cost'), 'invalid': isInvalid('book_cost')}\" />\n                <label for=\"icon_prefix\" class=\"active\">Book Cost</label>\n\n                <div *ngIf=\"get('book_cost').errors && isInvalid('book_cost')\">\n                  <p class=\"error\" *ngIf=\"get('book_cost').errors.server\" [innerHtml]=\"get('book_cost').errors.server.join('<br/>')\"></p>\n                  <p class=\"error\" *ngIf=\"get('book_cost').errors.required\">This field is required.</p>\n                  <p class=\"error\" *ngIf=\"get('book_cost').errors.min\">Must be at least 0.</p>\n                </div>\n              </div>\n\n          </div>\n\n          <div class=\"col s12\" [hidden]=\"!book_addresses?.controls?.length\">\n            <ul class=\"collection\" formArrayName=\"book_addresses\">\n              <li class=\"collection-item row mb-n\"\n                *ngFor=\"let b of book_addresses?.controls; let i=index\"\n                [formGroupName]=\"i\">\n\n                <div class=\"input-field col m6\">\n                  <label for=\"address_line1\">Address Line 1</label>\n                  <input id=\"address_line1\"\n                    formControlName=\"line1\"\n                    required\n                    type=\"text\" />\n\n                    <div *ngIf=\"b.get('line1').errors && isInvalid(b.get('line1'))\">\n                      <p class=\"error\" *ngIf=\"b.get('line1').errors.server\" [innerHtml]=\"b.get('line1').errors.server.join('<br/>')\"></p>\n                    <p class=\"error\" *ngIf=\"b.get('line1').errors.required\">This field is required.</p>\n                  </div>\n                </div>\n\n                <div class=\"input-field col m6\">\n                  <label for=\"address_line2\">Address Line 2</label>\n                  <input id=\"address_line2\"\n                    formControlName=\"line2\"\n                    type=\"text\" />\n                </div>\n\n                <div class=\"input-field col m4 clear\">\n                  <label for=\"city\">City</label>\n                  <input id=\"city\"\n                    formControlName=\"city\"\n                    required\n                    type=\"text\" />\n\n                    <div *ngIf=\"b.get('city').errors && isInvalid(b.get('city'))\">\n                      <p class=\"error\" *ngIf=\"b.get('city').errors.server\" [innerHtml]=\"get('city').errors.server.join('<br/>')\"></p>\n                    <p class=\"error\" *ngIf=\"b.get('city').errors.required\">This field is required.</p>\n                  </div>\n                </div>\n\n                <div class=\" col m4\">\n                  <label for=\"state\">State</label>\n                  <select id=\"state\"\n                    class=\"browser-default block\"\n                    formControlName=\"state\"\n                    required>\n\n                    <option value=\"AL\">Alabama</option>\n                    <option value=\"AK\">Alaska</option>\n                    <option value=\"AZ\">Arizona</option>\n                    <option value=\"AR\">Arkansas</option>\n                    <option value=\"CA\" selected>California</option>\n                    <option value=\"CO\">Colorado</option>\n                    <option value=\"CT\">Connecticut</option>\n                    <option value=\"DE\">Delaware</option>\n                    <option value=\"DC\">District Of Columbia</option>\n                    <option value=\"FL\">Florida</option>\n                    <option value=\"GA\">Georgia</option>\n                    <option value=\"HI\">Hawaii</option>\n                    <option value=\"ID\">Idaho</option>\n                    <option value=\"IL\">Illinois</option>\n                    <option value=\"IN\">Indiana</option>\n                    <option value=\"IA\">Iowa</option>\n                    <option value=\"KS\">Kansas</option>\n                    <option value=\"KY\">Kentucky</option>\n                    <option value=\"LA\">Louisiana</option>\n                    <option value=\"ME\">Maine</option>\n                    <option value=\"MD\">Maryland</option>\n                    <option value=\"MA\">Massachusetts</option>\n                    <option value=\"MI\">Michigan</option>\n                    <option value=\"MN\">Minnesota</option>\n                    <option value=\"MS\">Mississippi</option>\n                    <option value=\"MO\">Missouri</option>\n                    <option value=\"MT\">Montana</option>\n                    <option value=\"NE\">Nebraska</option>\n                    <option value=\"NV\">Nevada</option>\n                    <option value=\"NH\">New Hampshire</option>\n                    <option value=\"NJ\">New Jersey</option>\n                    <option value=\"NM\">New Mexico</option>\n                    <option value=\"NY\">New York</option>\n                    <option value=\"NC\">North Carolina</option>\n                    <option value=\"ND\">North Dakota</option>\n                    <option value=\"OH\">Ohio</option>\n                    <option value=\"OK\">Oklahoma</option>\n                    <option value=\"OR\">Oregon</option>\n                    <option value=\"PA\">Pennsylvania</option>\n                    <option value=\"RI\">Rhode Island</option>\n                    <option value=\"SC\">South Carolina</option>\n                    <option value=\"SD\">South Dakota</option>\n                    <option value=\"TN\">Tennessee</option>\n                    <option value=\"TX\">Texas</option>\n                    <option value=\"UT\">Utah</option>\n                    <option value=\"VT\">Vermont</option>\n                    <option value=\"VA\">Virginia</option>\n                    <option value=\"WA\">Washington</option>\n                    <option value=\"WV\">West Virginia</option>\n                    <option value=\"WI\">Wisconsin</option>\n                    <option value=\"WY\">Wyoming</option>\n\n                  </select>\n\n                  <div class=\"mt-md\" *ngIf=\"b.get('state').errors && isInvalid(b.get('state'))\">\n                    <p class=\"error\" *ngIf=\"b.get('state').errors.server\" [innerHtml]=\"get('state').errors.server.join('<br/>')\"></p>\n                    <p class=\"error\" *ngIf=\"b.get('state').errors.required\">This field is required.</p>\n                  </div>\n                </div>\n\n                <div class=\"input-field col m4\">\n                  <label for=\"zip_code\">Zip Code</label>\n                  <input id=\"zip_code\"\n                    formControlName=\"zip_code\"\n                    required\n                    type=\"text\" />\n\n                  <div *ngIf=\"b.get('zip_code').errors && isInvalid(b.get('zip_code'))\">\n                    <p class=\"error\" *ngIf=\"b.get('zip_code').errors.server\" [innerHtml]=\"get('zip_code').errors.server.join('<br/>')\"></p>\n                    <p class=\"error\" *ngIf=\"b.get('zip_code').errors.required\">This field is required.</p>\n                  </div>\n                </div>\n\n                <div class=\"input-field col s12 clear\">\n                  <label for=\"special_instructions\">Special Instructions</label>\n                  <textarea id=\"special_instructions\"\n                    formControlName=\"special_instructions\"\n                    class=\"materialize-textarea\">\n                  </textarea>\n                </div>\n\n              </li>\n            </ul>\n          </div>\n\n        </div>\n\n\n        <div class=\"section row\">\n          <div class=\"ctb-title sm col s12\">\n            <h6>Addons</h6>\n          </div>\n\n          <div class=\"col m6\">\n            <div class=\"counter indigo lighten-1 mt-md\">\n              <span class=\"dec\" (click)=\"decrement('addon_count')\">-</span>\n              <input type=\"text\"\n                formControlName=\"addon_count\"\n                pattern=\"[0-9]+\"\n                required />\n              <span class=\"inc\" (click)=\"increment('addon_count')\">+</span>\n            </div>\n\n            <div *ngIf=\"get('addon_count').errors && isInvalid('addon_count')\" class=\"mt-md\">\n              <p class=\"error\" *ngIf=\"get('addon_count').errors.server\" [innerHtml]=\"get('addon_count').errors.server.join('<br/>')\"></p>\n              <p class=\"error\" *ngIf=\"get('addon_count').errors.required\">This field is required.</p>\n              <p class=\"error\" *ngIf=\"get('addon_count').errors.min\">Must be at least 0.</p>\n            </div>\n          </div>\n\n          <div class=\"col m6\">\n\n              <div class=\"input-field cost-field\">\n                <i class=\"material-icons prefix\">attach_money</i>\n                <input id=\"addon_cost\"\n                  type=\"number\"\n                  formControlName=\"addon_cost\"\n                  required\n                  min=\"0\"\n                  [ngClass]=\"{'valid': isValid('addon_cost'), 'invalid': isInvalid('addon_cost')}\" />\n                <label for=\"icon_prefix\" class=\"active\">Addon Cost</label>\n\n                <div *ngIf=\"get('addon_cost').errors && isInvalid('addon_cost')\">\n                  <p class=\"error\" *ngIf=\"get('addon_cost').errors.server\" [innerHtml]=\"get('addon_cost').errors.server.join('<br/>')\"></p>\n                  <p class=\"error\" *ngIf=\"get('addon_cost').errors.required\">This field is required.</p>\n                  <p class=\"error\" *ngIf=\"get('addon_cost').errors.min\">Must be at least 0.</p>\n                </div>\n              </div>\n\n          </div>\n\n          <div class=\"col s12\" [hidden]=\"!addons?.controls.length\">\n            <ul class=\"collection\" formArrayName=\"addons\">\n              <li class=\"collection-item row mb-n\"\n                *ngFor=\"let addon of addons?.controls; let i = index\">\n\n                <div class=\"input-field\">\n                  <label>Addon Email #{{i+1}}</label>\n                  <input [formControlName]=\"i\"\n                    type=\"email\" />\n\n                  <div *ngIf=\"get('addons.' + i).errors && isInvalid('addons.' + i)\">\n                    <p class=\"error\" *ngIf=\"get('addons.' + i).errors.server\" [innerHtml]=\"get('addons.' + i).errors.server.join('<br/>')\"></p>\n                    <p class=\"error\" *ngIf=\"get('addons.' + i).errors.required\">This field is required.</p>\n                    <p class=\"error\" *ngIf=\"get('addons.' + i).errors.email\">Email is not valid.</p>\n                  </div>\n                </div>\n\n              </li>\n\n            </ul>\n          </div>\n\n        </div>\n\n      </div>\n    </div>\n\n    <div class=\"row\">\n      <div class=\"ctb-title col s12\">\n        <h5>Payment</h5>\n      </div>\n\n      <div class=\"card-panel col s12\">\n        <div class=\"row\">\n          <div class=\"col m12 l12 xl6 pt-md mb-lg\">\n            <div class=\"ctb-title sm\">\n              <h6>Payment Method</h6>\n            </div>\n            <p>\n              <input id=\"pay_stripe\"\n                value=\"stripe\"\n                formControlName=\"payment_method\"\n                type=\"radio\" />\n              <label for=\"pay_stripe\">Paying By Credit Card</label>\n            </p>\n            <p>\n              <input id=\"pay_check\"\n                value=\"check\"\n                formControlName=\"payment_method\"\n                type=\"radio\" />\n              <label for=\"pay_check\">Paying By Check</label>\n            </p>\n\n            <div class=\"input-field mt-sm\"\n              [hidden]=\"subscriberForm.value.payment_method !== 'stripe'\">\n              <ctb-stripe-input\n                required\n                [class.valid]=\"get('stripe_token').value && !get('stripe_token').errors\"\n                [class.invalid]=\"get('stripe_token').touched && get('stripe_token').errors\"\n                formControlName=\"stripe_token\"\n              ></ctb-stripe-input>\n\n              <div *ngIf=\"get('stripe_token').errors\" class=\"mt-md\">\n                <p class=\"error\" *ngIf=\"get('stripe_token').errors.server\" [innerHtml]=\"get('stripe_token').errors.server.join('<br/>')\"></p>\n                <p class=\"error\" *ngIf=\"get('stripe_token').errors.stripe\">{{stripe_token.errors.stripe}}</p>\n              </div>\n            </div>\n\n          </div>\n\n          <div class=\"col m12 l12 xl6 pt-md mb-lg\">\n            <div class=\"ctb-title sm\">\n              <h6>Paid Up</h6>\n            </div>\n            <p>\n              Check this box to mark the subscriber as paid.\n              This will make their subscription active.\n              This will not charge them.\n            </p>\n            <div class=\"form-group\">\n              <input type=\"checkbox\"\n                id=\"is_paid_for\"\n                formControlName=\"is_paid_for\" />\n              <label for=\"is_paid_for\">Is Paid For</label>\n            </div>\n\n            <div class=\"form-group\">\n              <input type=\"checkbox\"\n                id=\"send_invoice\"\n                formControlName=\"send_invoice\" />\n              <label for=\"send_invoice\">Email Invoice</label>\n            </div>\n\n          </div>\n\n        </div>\n\n\n      </div>\n\n    </div>\n\n    <div class=\"row\">\n      <div class=\"ctb-title col s12\">\n        <h5>Summary</h5>\n      </div>\n\n      <div class=\"card-panel col s12 p-n\">\n        <table class=\"bordered\">\n          <tr>\n            <th>Base Subscription</th>\n            <td>${{totals.base}}</td>\n          </tr>\n          <tr>\n            <th>Hard Copies</th>\n            <td>${{totals.books}}</td>\n          </tr>\n          <tr>\n            <th>Addons</th>\n            <td>${{totals.addons}}</td>\n          </tr>\n          <tr class=\"blue-grey lighten-5\">\n            <th>Total</th>\n            <td>${{totals.total}}</td>\n          </tr>\n        </table>\n      </div>\n\n    </div>\n\n    <div class=\"row\">\n      <ctb-loader class=\"left\" classes=\"small\" *ngIf=\"formIsLoading\"></ctb-loader>\n\n      <button type=\"submit\"\n          [disabled]=\"subscriberForm.invalid || formIsLoading\"\n          class=\"waves-effect waves-light btn right\">\n        Submit\n      </button>\n    </div>\n\n  </form>\n</div>\n"

/***/ }),

/***/ "../../../../../resources/assets/admin/app/users/user-create/user-create.component.scss":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("../../../../css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".cost-field input {\n  text-align: right;\n  font-size: 26px; }\n\n.counter {\n  width: 120px;\n  position: relative;\n  display: inline-block;\n  padding: 0;\n  -webkit-user-select: none;\n     -moz-user-select: none;\n      -ms-user-select: none;\n          user-select: none;\n  text-align: center;\n  cursor: pointer; }\n  .counter * {\n    width: 33%;\n    color: #fff;\n    float: left;\n    display: inline-block;\n    margin: 0;\n    text-align: center;\n    padding: 5px 0;\n    font-size: 18px;\n    height: auto;\n    border: 0; }\n  .counter span {\n    background: rgba(0, 0, 0, 0.2); }\n    .counter span:active {\n      background: rgba(0, 0, 0, 0.1); }\n", ""]);

// exports


/*** EXPORTS FROM exports-loader ***/
module.exports = module.exports.toString();

/***/ }),

/***/ "../../../../../resources/assets/admin/app/users/user-create/user-create.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return UserCreateComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("../../../core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_forms__ = __webpack_require__("../../../forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_router__ = __webpack_require__("../../../router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_app_core_user_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/user.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_app_core_snackbar_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/snackbar.service.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





var UserCreateComponent = (function () {
    function UserCreateComponent(cdr, fb, userService, router, snackbar) {
        var _this = this;
        this.cdr = cdr;
        this.fb = fb;
        this.userService = userService;
        this.router = router;
        this.snackbar = snackbar;
        this.pricing = {
            base: { '12': 1200, '24': 2200 },
        };
        this.totals = {
            base: 0,
            addons: 0,
            books: 0,
            total: 0,
        };
        this.subscriberForm = this.fb.group({
            first_name: ['', __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            last_name: ['', __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            email: ['', [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].email]],
            company: this.fb.group({
                name: [''],
                address: this.fb.group({
                    line1: [''],
                    line2: [''],
                    city: [''],
                    state: [''],
                    zip_code: [''],
                })
            }),
            phone_number: [''],
            subscription_length: ['24', __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            book_count: [0, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].min(0)],
            book_addresses: this.fb.array([]),
            addon_count: [0, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].min(0)],
            addons: this.fb.array([]),
            subscription_cost: [2200, [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].min(0)]],
            book_cost: [
                100 * window.globals.getBookCountForSubscription(2),
                [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].min(0)],
            ],
            addon_cost: [200, [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].min(0)]],
            payment_method: ['stripe', __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            stripe_token: [],
            is_paid_for: [false],
            send_invoice: [true],
        });
        /**
         * Watch
         */
        this.subscriberForm.get('subscription_length').valueChanges
            .forEach(function (freq) {
            _this.subscriberForm.patchValue({
                subscription_cost: _this.pricing.base[freq],
                book_cost: 100 * window.globals.getBookCountForSubscription(+freq / 12),
                addon_cost: 100 * (+freq / 12),
            });
        });
        this.subscriberForm.get('stripe_token').valueChanges
            .distinctUntilChanged()
            .forEach(function (tok) {
            _this.subscriberForm.get('stripe_token').updateValueAndValidity();
            _this.cdr.detectChanges();
        });
        this.subscriberForm.get('payment_method').valueChanges
            .forEach(function (method) {
            var t = _this.subscriberForm.get('stripe_token');
            t.clearValidators();
            t.reset();
            t.setValidators(method === 'stripe' ? __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required : []);
            t.updateValueAndValidity();
        });
        this.subscriberForm.get('book_count').valueChanges
            .forEach(function (count) {
            var addresses = _this.subscriberForm.get('book_addresses');
            var cur = addresses.value;
            if (cur.length < count) {
                var add = Array(count - cur.length)
                    .fill(_this.fb.group({
                    line1: ['', __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
                    line2: [''],
                    city: ['', __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
                    state: ['', __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
                    zip_code: ['', __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
                    special_instructions: [''],
                }))
                    .forEach(function (fg) { return addresses.push(fg); });
            }
            else {
                Array(cur.length - count).fill(0)
                    .map(function (_, i) { return cur.length - i - 1; })
                    .forEach(function (i) { return addresses.removeAt(i); });
            }
        });
        this.subscriberForm.get('addon_count').valueChanges
            .forEach(function (count) {
            var addons = _this.subscriberForm.get('addons');
            var cur = addons.value;
            if (cur.length < count) {
                var add = Array(count - cur.length)
                    .fill(_this.fb.control('', [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].email]))
                    .forEach(function (fg) { return addons.push(fg); });
            }
            else {
                Array(cur.length - count).fill(0)
                    .map(function (_, i) { return cur.length - i - 1; })
                    .forEach(function (i) { return addons.removeAt(i); });
            }
        });
        this.subscriberForm.valueChanges
            .forEach(function (f) {
            // update totals
            var totals = {
                base: f.subscription_cost,
                addons: f.addon_count * f.addon_cost,
                books: f.book_count * f.book_cost,
                total: 0,
            };
            totals.total = totals.base + totals.addons + totals.books;
            _this.totals = totals;
            // Erase server errors,
            // Need to remove the server error after input
            //  so that the form will be seen as valid
            (function checkServerErrors(controls) {
                controls.forEach(function (c) {
                    if (c instanceof __WEBPACK_IMPORTED_MODULE_1__angular_forms__["c" /* FormArray */]) {
                        return checkServerErrors(c.controls);
                    }
                    if (c.hasError('server') && c.dirty) {
                        var e = c.errors;
                        delete c.errors.server;
                        c.setErrors(e);
                    }
                });
            })(Object.keys(_this.subscriberForm.controls)
                .map(function (k) { return _this.subscriberForm.controls[k]; }));
        });
    }
    Object.defineProperty(UserCreateComponent.prototype, "book_addresses", {
        get: function () {
            return this.subscriberForm.get('book_addresses');
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(UserCreateComponent.prototype, "addons", {
        get: function () {
            return this.subscriberForm.get('addons');
        },
        enumerable: true,
        configurable: true
    });
    UserCreateComponent.prototype.ngOnInit = function () {
    };
    UserCreateComponent.prototype.onSubmit = function (form) {
        var _this = this;
        this.submitted = true;
        if (form.invalid)
            return false;
        this.formIsLoading = true;
        var body = form.value;
        var stripeMultiplier = 100;
        body.subscription_cost *= stripeMultiplier;
        body.book_cost *= stripeMultiplier;
        body.addon_cost *= stripeMultiplier;
        this.userService.create(body)
            .subscribe(function (user) {
            console.log(user);
            _this.formIsLoading = false;
            _this.snackbar.snack('Subscriber created successfully');
            _this.router.navigate(['/contacts', user.id]);
        }, function (res) {
            _this.formIsLoading = false;
            _this.snackbar.error('There are some form errors.');
            _this.subscriberForm.markAsPristine();
            Object.keys(res.error.errors)
                .map(function (k) {
                _this.subscriberForm.get(k)
                    .setErrors({ server: res.error.errors[k] });
            });
        });
    };
    UserCreateComponent.prototype.isValid = function (field) {
        var c;
        if (field instanceof __WEBPACK_IMPORTED_MODULE_1__angular_forms__["a" /* AbstractControl */]) {
            c = field;
        }
        else {
            c = this.subscriberForm.get(field);
        }
        return c.valid;
    };
    UserCreateComponent.prototype.isInvalid = function (field) {
        var c;
        if (field instanceof __WEBPACK_IMPORTED_MODULE_1__angular_forms__["a" /* AbstractControl */]) {
            c = field;
        }
        else {
            c = this.subscriberForm.get(field);
        }
        return c.invalid && (c.dirty || c.touched || this.submitted);
    };
    UserCreateComponent.prototype.get = function (field) {
        return this.subscriberForm.get(field);
    };
    UserCreateComponent.prototype.decrement = function (field) {
        var c = this.subscriberForm.get(field);
        c.setValue(+c.value <= 0 ? 0 : +c.value - 1);
    };
    UserCreateComponent.prototype.increment = function (field) {
        var c = this.subscriberForm.get(field);
        c.setValue(+c.value + 1);
    };
    UserCreateComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'ctb-user-create',
            template: __webpack_require__("../../../../../resources/assets/admin/app/users/user-create/user-create.component.html"),
            styles: [__webpack_require__("../../../../../resources/assets/admin/app/users/user-create/user-create.component.scss")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_0__angular_core__["ChangeDetectorRef"],
            __WEBPACK_IMPORTED_MODULE_1__angular_forms__["d" /* FormBuilder */],
            __WEBPACK_IMPORTED_MODULE_3_app_core_user_service__["a" /* UserService */],
            __WEBPACK_IMPORTED_MODULE_2__angular_router__["c" /* Router */],
            __WEBPACK_IMPORTED_MODULE_4_app_core_snackbar_service__["a" /* SnackbarService */]])
    ], UserCreateComponent);
    return UserCreateComponent;
}());



/***/ }),

/***/ "../../../../../resources/assets/admin/app/users/user-create/user-create.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "UserCreateModule", function() { return UserCreateModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("../../../core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_forms__ = __webpack_require__("../../../forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_router__ = __webpack_require__("../../../router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_app_shared_shared_module__ = __webpack_require__("../../../../../resources/assets/admin/app/shared/shared.module.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__user_create_component__ = __webpack_require__("../../../../../resources/assets/admin/app/users/user-create/user-create.component.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};





var UserCreateModule = (function () {
    function UserCreateModule() {
    }
    UserCreateModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [
                __WEBPACK_IMPORTED_MODULE_3_app_shared_shared_module__["a" /* SharedModule */],
                __WEBPACK_IMPORTED_MODULE_1__angular_forms__["k" /* ReactiveFormsModule */],
                __WEBPACK_IMPORTED_MODULE_2__angular_router__["d" /* RouterModule */].forChild([{ path: '', component: __WEBPACK_IMPORTED_MODULE_4__user_create_component__["a" /* UserCreateComponent */] }])
            ],
            declarations: [__WEBPACK_IMPORTED_MODULE_4__user_create_component__["a" /* UserCreateComponent */]]
        })
    ], UserCreateModule);
    return UserCreateModule;
}());



/***/ })

});
//# sourceMappingURL=user-create.module.chunk.js.map