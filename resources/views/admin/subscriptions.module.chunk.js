webpackJsonp(["subscriptions.module"],{

/***/ "../../../../../resources/assets/admin/app/subscriptions/subscription/change-cycle-end-modal.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ChangeCycleEndModalComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("../../../core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_forms__ = __webpack_require__("../../../forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_material__ = __webpack_require__("../../../material/esm5/material.es5.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_moment__ = __webpack_require__("../../../../moment/moment.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_moment__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_app_core_cycle_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/cycle.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_app_core_snackbar_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/snackbar.service.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};






var ChangeCycleEndModalComponent = (function () {
    function ChangeCycleEndModalComponent(dialogRef, fb, cycleService, snackbar, data) {
        this.dialogRef = dialogRef;
        this.fb = fb;
        this.cycleService = cycleService;
        this.snackbar = snackbar;
        this.data = data;
        this.form = fb.group({
            date: [data.cycle.ends_on, [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required]],
        });
    }
    ChangeCycleEndModalComponent.prototype.ngOnInit = function () {
    };
    ChangeCycleEndModalComponent.prototype.cancel = function () {
        this.dialogRef.close();
    };
    ChangeCycleEndModalComponent.prototype.onNoClick = function () {
        this.cancel();
    };
    ChangeCycleEndModalComponent.prototype.onSubmit = function (form) {
        var _this = this;
        if (form.invalid)
            return false;
        this.formIsLoading = true;
        var ends_on = __WEBPACK_IMPORTED_MODULE_3_moment___default()(form.value.date).format('YYYY-MM-DD');
        this.cycleService.update(this.data.cycle.id, { ends_on: ends_on })
            .subscribe(function (cycle) {
            _this.formIsLoading = false;
            _this.snackbar.snack('Updated Subscription Expiration.');
            _this.dialogRef.close({ cycle: cycle });
        }, function (err) {
            console.error(err);
            _this.formIsLoading = false;
            _this.snackbar.error('Something went wrong.');
        });
    };
    ChangeCycleEndModalComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'ctb-change-cycle-end-modal',
            template: "\n\n    <form [formGroup]=\"form\" (submit)=\"onSubmit(form)\">\n\n      <h3 mat-dialog-title>Change Subscription Expiration</h3>\n\n      <mat-dialog-content>\n\n        <div class=\"form-group center-block\">\n          <input formControlName=\"date\" matInput [matDatepicker]=\"picker\">\n          <mat-datepicker-toggle matSuffix [for]=\"picker\"></mat-datepicker-toggle>\n          <mat-datepicker #picker></mat-datepicker>\n        </div>\n\n      </mat-dialog-content>\n\n      <mat-dialog-actions>\n\n        <button mat-button mat-dialog-close\n            class=\"btn z-depth-0 waves-effect waves-light blue-grey lighten-5 blue-grey-text left\" (click)=\"cancel()\"\n            type=\"submit\">\n          Cancel\n        </button>\n\n        <ctb-loader class=\"right\" classes=\"small\" *ngIf=\"formIsLoading\"></ctb-loader>\n        <button mat-button type=\"submit\" [disabled]=\"formIsLoading\" class=\"waves-effect waves-light btn right right\">\n          Save\n        </button>\n      </mat-dialog-actions>\n    </form>\n  ",
            styles: ["\n      .form-group {\n          position: relative;\n      }\n      mat-datepicker-toggle {\n          position: absolute;\n          top: 0;\n          right: 0; \n      }\n  "],
        }),
        __param(4, Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Inject"])(__WEBPACK_IMPORTED_MODULE_2__angular_material__["a" /* MAT_DIALOG_DATA */])),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_2__angular_material__["e" /* MatDialogRef */],
            __WEBPACK_IMPORTED_MODULE_1__angular_forms__["d" /* FormBuilder */],
            __WEBPACK_IMPORTED_MODULE_4_app_core_cycle_service__["a" /* CycleService */],
            __WEBPACK_IMPORTED_MODULE_5_app_core_snackbar_service__["a" /* SnackbarService */], Object])
    ], ChangeCycleEndModalComponent);
    return ChangeCycleEndModalComponent;
}());



/***/ }),

/***/ "../../../../../resources/assets/admin/app/subscriptions/subscription/create-addon-modal/create-addon-modal.component.html":
/***/ (function(module, exports) {

module.exports = "\n\n<form [formGroup]=\"addonForm\"\n    (submit)=\"onSubmit(addonForm)\">\n\n  <h3 mat-dialog-title>Create Addon Account</h3>\n\n  <mat-dialog-content>\n\n    <div class=\"input-field col m6\">\n      <label for=\"first_name\">First Name</label>\n      <input id=\"first_name\"\n          formControlName=\"first_name\"\n          autocomplete=\"off\"\n          [ngClass]=\"{'valid': isValid('first_name'), 'invalid': isInvalid('first_name')}\"\n          type=\"text\" />\n\n      <div *ngIf=\"get('first_name').errors && isInvalid('first_name')\">\n        <p class=\"error\" *ngIf=\"get('first_name').errors.server\" [innerHtml]=\"get('first_name').errors.server.join('<br/>')\"></p>\n      </div>\n    </div>\n\n    <div class=\"input-field col m6\">\n      <label for=\"last_name\">Last Name</label>\n      <input id=\"last_name\"\n          formControlName=\"last_name\"\n          autocomplete=\"off\"\n          [ngClass]=\"{'valid': isValid('last_name'), 'invalid': isInvalid('last_name')}\"\n          type=\"text\" />\n\n      <div *ngIf=\"get('last_name').errors && isInvalid('last_name')\">\n        <p class=\"error\" *ngIf=\"get('last_name').errors.server\" [innerHtml]=\"get('last_name').errors.server.join('<br/>')\"></p>\n      </div>\n    </div>\n\n    <div class=\"input-field col m12\">\n      <label for=\"email\">Addon Email</label>\n      <input id=\"email\"\n          formControlName=\"email\"\n          required\n          autocomplete=\"off\"\n          [ngClass]=\"{'valid': isValid('email'), 'invalid': isInvalid('email')}\"\n          type=\"email\" />\n\n      <div *ngIf=\"get('email').errors && isInvalid('email')\">\n        <p class=\"error\" *ngIf=\"get('email').errors.required\">This field is required.</p>\n        <p class=\"error\" *ngIf=\"get('email').errors.email\">Not a valid email.</p>\n        <p class=\"error\" *ngIf=\"get('email').errors.server\" [innerHtml]=\"get('email').errors.server.join('<br/>')\"></p>\n      </div>\n    </div>\n\n\n  </mat-dialog-content>\n\n  <mat-dialog-actions>\n\n    <button mat-button mat-dialog-close class=\"btn z-depth-0 waves-effect waves-light blue-grey lighten-5 blue-grey-text left\"\n        (click)=\"cancel()\"\n        type=\"submit\">\n      Cancel\n    </button>\n\n    <ctb-loader class=\"right\" classes=\"small\" *ngIf=\"formIsLoading\"></ctb-loader>\n    <button mat-button type=\"submit\"\n        [disabled]=\"addonForm.invalid || formIsLoading\"\n        class=\"waves-effect waves-light btn right right\">\n      Create\n    </button>\n\n  </mat-dialog-actions>\n\n</form>\n\n"

/***/ }),

/***/ "../../../../../resources/assets/admin/app/subscriptions/subscription/create-addon-modal/create-addon-modal.component.scss":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("../../../../css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "", ""]);

// exports


/*** EXPORTS FROM exports-loader ***/
module.exports = module.exports.toString();

/***/ }),

/***/ "../../../../../resources/assets/admin/app/subscriptions/subscription/create-addon-modal/create-addon-modal.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return CreateAddonModalComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("../../../core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_forms__ = __webpack_require__("../../../forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_material__ = __webpack_require__("../../../material/esm5/material.es5.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_app_core_snackbar_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/snackbar.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__core_subscription_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/subscription.service.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};





var CreateAddonModalComponent = (function () {
    function CreateAddonModalComponent(dialogRef, fb, subService, snackbar, data) {
        this.dialogRef = dialogRef;
        this.fb = fb;
        this.subService = subService;
        this.snackbar = snackbar;
        this.data = data;
        this.addonForm = fb.group({
            email: ['', [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].email]],
            first_name: [''],
            last_name: [''],
        });
    }
    CreateAddonModalComponent.prototype.ngOnInit = function () {
    };
    CreateAddonModalComponent.prototype.cancel = function () {
        this.dialogRef.close();
    };
    CreateAddonModalComponent.prototype.onNoClick = function () {
        this.cancel();
    };
    CreateAddonModalComponent.prototype.onSubmit = function (form) {
        var _this = this;
        this.submitted = true;
        if (form.invalid)
            return false;
        this.formIsLoading = true;
        this.subService.createAddon(this.data.subscriptionId, form.value)
            .subscribe(function (sub) {
            _this.formIsLoading = false;
            _this.snackbar.snack('Created Add-on Account Successfully.');
            _this.dialogRef.close();
        }, function (res) {
            _this.formIsLoading = false;
            _this.snackbar.error('There are some form errors.');
            _this.addonForm.markAsPristine();
            Object.keys(res.error.errors)
                .map(function (k) {
                _this.addonForm.get(k)
                    .setErrors({ server: res.error.errors[k] });
            });
        });
    };
    CreateAddonModalComponent.prototype.isValid = function (field) {
        var c;
        if (field instanceof __WEBPACK_IMPORTED_MODULE_1__angular_forms__["a" /* AbstractControl */]) {
            c = field;
        }
        else {
            c = this.addonForm.get(field);
        }
        return c.valid;
    };
    CreateAddonModalComponent.prototype.isInvalid = function (field) {
        var c;
        if (field instanceof __WEBPACK_IMPORTED_MODULE_1__angular_forms__["a" /* AbstractControl */]) {
            c = field;
        }
        else {
            c = this.addonForm.get(field);
        }
        return c.invalid && (c.dirty || c.touched || this.submitted);
    };
    CreateAddonModalComponent.prototype.get = function (field) {
        return this.addonForm.get(field);
    };
    CreateAddonModalComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'ctb-create-addon-modal',
            template: __webpack_require__("../../../../../resources/assets/admin/app/subscriptions/subscription/create-addon-modal/create-addon-modal.component.html"),
            styles: [__webpack_require__("../../../../../resources/assets/admin/app/subscriptions/subscription/create-addon-modal/create-addon-modal.component.scss")]
        }),
        __param(4, Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Inject"])(__WEBPACK_IMPORTED_MODULE_2__angular_material__["a" /* MAT_DIALOG_DATA */])),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_2__angular_material__["e" /* MatDialogRef */],
            __WEBPACK_IMPORTED_MODULE_1__angular_forms__["d" /* FormBuilder */],
            __WEBPACK_IMPORTED_MODULE_4__core_subscription_service__["a" /* SubscriptionService */],
            __WEBPACK_IMPORTED_MODULE_3_app_core_snackbar_service__["a" /* SnackbarService */], Object])
    ], CreateAddonModalComponent);
    return CreateAddonModalComponent;
}());



/***/ }),

/***/ "../../../../../resources/assets/admin/app/subscriptions/subscription/subscription.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"row page-heading\">\n  <h1>\n    Subscription\n    <small>{{ (sub$ | async)?.company }}</small>\n  </h1>\n</div>\n\n<div>\n\n  <div class=\"row\" [hidden]=\"sub$ | async\">\n    <div class=\"preloader-wrapper active m-auto fn block\">\n      <div class=\"spinner-layer spinner-red-only\">\n        <div class=\"circle-clipper left\">\n          <div class=\"circle\"></div>\n        </div><div class=\"gap-patch\">\n        <div class=\"circle\"></div>\n      </div><div class=\"circle-clipper right\">\n        <div class=\"circle\"></div>\n      </div>\n      </div>\n    </div>\n\n  </div>\n\n  <div [hidden]=\"!(sub$ | async)\">\n\n    <div class=\"row\" >\n      <div class=\"col s12\">\n        <div class=\"card-panel\">\n\n          <div class=\"row section\">\n\n            <div class=\"ctb-title sm\">\n              <h5>Cycle</h5>\n            </div>\n            <ul class=\"collection cycles\">\n              <li class=\"collection-item active-cycle\" *ngIf=\"(sub$ | async)?.cycle\">\n                <table class=\"\">\n                  <tr>\n                    <th>Starts On</th>\n                    <td>{{ (sub$ | async)?.cycle.starts_on | date }}</td>\n                    <th>Ends On</th>\n                    <td>\n                      <span>\n\n                      {{ (sub$ | async)?.cycle.ends_on | date }}\n                      </span>\n\n                      <a (click)=\"updateCycleEnd()\" class=\"right teal-text\">\n                        <i class=\"material-icons\">mode_edit</i>\n                      </a>\n\n                    </td>\n                  </tr>\n                  <tr>\n                    <th>Payment Method</th>\n                    <td class=\"capitalize\">{{ (sub$ | async)?.cycle.payment_method }}</td>\n                    <th>Stripe Invoice Id</th>\n                    <td>\n                      <a [href]=\"(sub$ | async)?.cycle.invoice_id | stripeLink\" target=\"_blank\">\n                        {{ (sub$ | async)?.cycle.invoice_id }}\n                      </a>\n                    </td>\n                  </tr>\n\n                </table>\n              </li>\n              <li class=\"collection-item\" [hidden]=\"!(sub$ | async)?.pastCycles?.length || (sub$ | async)?.showPastCycles\">\n                <a (click)=\"showPastCycles = true\" class=\" block center-align\">\n                  Show Past Cycles\n                  <i class=\"material-icons va-middle\">arrow_forward</i>\n                </a>\n              </li>\n              <li class=\"collection-item\" [hidden]=\"!showPastCycles\"\n                  *ngFor=\"let c of (sub$ | async)?.inactiveCycles\">\n                <table class=\"\">\n                  <tr>\n\n                    <th>Starts On</th>\n                    <td>{{ (c.starts_on | date) || 'TBD' }}</td>\n                    <th>Ends On</th>\n                    <td>{{ (c.ends_on | date) || 'TBD' }}</td>\n\n                  </tr>\n                  <tr>\n                    <th>Payment Method</th>\n                    <td class=\"capitalize\">{{ c.payment_method }}</td>\n\n                    <th>Stripe Invoice Id</th>\n                    <td>\n                      <a [href]=\"c.invoice_id | stripeLink\" target=\"_blank\">\n                        {{ c.invoice_id }}\n                      </a>\n                    </td>\n                  </tr>\n\n                  <tr *ngIf=\"c.isPending\">\n                    <td>\n                      <ctb-loader *ngIf=\"loadingMarkPaid\" classes=\"small\"></ctb-loader>\n                    </td>\n                    <td></td>\n                    <td></td>\n                    <td>\n                      <button class=\"waves-effect waves-light btn right\"\n                          [disabled]=\"loadingMarkPaid\"\n                          (click)=\"markPaid(c)\">\n                        Mark Paid\n                      </button>\n                    </td>\n                  </tr>\n\n                </table>\n              </li>\n\n\n            </ul>\n          </div>\n\n          <div class=\"row\">\n\n            <div class=\"ctb-title sm clearfix\">\n              <h5 class=\"left\">Subscribers</h5>\n\n              <button class=\"waves-effect waves-light btn right mt-sm\"\n                  (click)=\"createAddon()\">\n                Create Add-On\n              </button>\n            </div>\n            <ul class=\"collection clear mt-md\">\n              <li class=\"collection-item\" *ngFor=\"let u of (sub$ | async)?.users\">\n                <div class=\"\">\n                  <h6>{{u.first_name}} {{u.last_name}}</h6>\n                  <a [href]=\"'mailto:' + u.email\">{{u.email}}</a>\n                  <p class=\"capitalize m-n light\">{{ u.pivot?.role }}</p>\n                </div>\n                <a [routerLink]=\"['/contacts', u.id]\" class=\"go-arrow\">\n                  <i class=\"material-icons\">arrow_forward</i>\n                </a>\n\n              </li>\n            </ul>\n          </div>\n\n          <div class=\"row\">\n\n            <div class=\"ctb-title sm\">\n              <h5>Book Subscriptions</h5>\n            </div>\n            <ul class=\"collection\">\n              <li class=\"collection-item row\" *ngFor=\"let b of (sub$ | async)?.bookSubscriptions\">\n                <div class=\"col s6\">\n                  <h6>Address</h6>\n                  <div class=\"address\">\n                    <p class=\"light\">{{b.address.line1}}</p>\n                    <p class=\"light\" [hidden]=\"!b.address.line2\">{{b.address.line2}}</p>\n                    <p class=\"light\">\n                      {{b.address.city}},\n                      {{b.address.state}}\n                      {{b.address.zip_code}}\n                    </p>\n                  </div>\n                </div>\n\n                <div class=\"col s6\">\n                  <h6>Special Instructions</h6>\n                  <p class=\"light\">{{b.address.special_instructions || 'N/A'}}</p>\n                </div>\n              </li>\n            </ul>\n          </div>\n\n\n        </div>\n      </div>\n    </div>\n\n  </div>\n</div>\n"

/***/ }),

/***/ "../../../../../resources/assets/admin/app/subscriptions/subscription/subscription.component.scss":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("../../../../css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".go-arrow {\n  position: absolute;\n  right: 20px;\n  top: 50%;\n  -webkit-transform: translateY(-50%);\n          transform: translateY(-50%); }\n\n.address p {\n  margin: 0; }\n\n.cycles .collection-item {\n  border-left: 5px solid #b23c3c; }\n  .cycles .collection-item a {\n    cursor: pointer; }\n  .cycles .collection-item.active-cycle {\n    border-left-color: #4caf50; }\n\n.account-card input {\n  margin: 0;\n  padding: 5px;\n  height: auto; }\n", ""]);

// exports


/*** EXPORTS FROM exports-loader ***/
module.exports = module.exports.toString();

/***/ }),

/***/ "../../../../../resources/assets/admin/app/subscriptions/subscription/subscription.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return SubscriptionComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("../../../core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("../../../router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_app_core_cycle_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/cycle.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_app_core_subscription_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/subscription.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_app_core_snackbar_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/snackbar.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__create_addon_modal_create_addon_modal_component__ = __webpack_require__("../../../../../resources/assets/admin/app/subscriptions/subscription/create-addon-modal/create-addon-modal.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__angular_material__ = __webpack_require__("../../../material/esm5/material.es5.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__change_cycle_end_modal_component__ = __webpack_require__("../../../../../resources/assets/admin/app/subscriptions/subscription/change-cycle-end-modal.component.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};








var SubscriptionComponent = (function () {
    function SubscriptionComponent(cycleService, subscriptionService, route, router, snackbar, dialog) {
        this.cycleService = cycleService;
        this.subscriptionService = subscriptionService;
        this.route = route;
        this.router = router;
        this.snackbar = snackbar;
        this.dialog = dialog;
        this.router.onSameUrlNavigation = 'reload';
        this.router.routeReuseStrategy.shouldReuseRoute = function () { return false; };
    }
    SubscriptionComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.route.params.subscribe(function (params) {
            _this.subId = params.id;
            _this.sub$ = _this.subscriptionService.get(_this.subId)
                .map(function (sub) {
                console.log(sub);
                _this.showPastCycles = !sub.cycle;
                if (sub.inactiveCycles) {
                    sub.inactiveCycles.forEach(function (c) {
                        c.isPending = !c.starts_on && !c.ends_on;
                    });
                }
                _this.sub = sub;
                return sub;
            })
                .share();
        });
    };
    SubscriptionComponent.prototype.markPaid = function (cycle) {
        var _this = this;
        this.loadingMarkPaid = true;
        this.cycleService.markPaid(cycle.id)
            .subscribe(function (res) {
            _this.loadingMarkPaid = false;
            _this.router.navigateByUrl(_this.router.url);
            _this.snackbar.snack('Subscription is now activate.');
        }, function (err) {
            _this.loadingMarkPaid = false;
            _this.snackbar.error('Something went wrong.');
        });
    };
    SubscriptionComponent.prototype.updateCycleEnd = function () {
        var _this = this;
        var dialogRef = this.dialog.open(__WEBPACK_IMPORTED_MODULE_7__change_cycle_end_modal_component__["a" /* ChangeCycleEndModalComponent */], {
            // height: '240px',
            width: '400px',
            data: { cycle: this.sub.cycle },
        });
        dialogRef.afterClosed()
            .subscribe(function (_a) {
            var cycle = _a.cycle;
            return Object.assign(_this.sub.cycle, cycle);
        });
    };
    SubscriptionComponent.prototype.createAddon = function () {
        var dialogRef = this.dialog.open(__WEBPACK_IMPORTED_MODULE_5__create_addon_modal_create_addon_modal_component__["a" /* CreateAddonModalComponent */], {
            // height: '240px',
            width: '400px',
            data: { subscriptionId: this.subId },
        });
    };
    SubscriptionComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'ctb-subscription',
            template: __webpack_require__("../../../../../resources/assets/admin/app/subscriptions/subscription/subscription.component.html"),
            styles: [__webpack_require__("../../../../../resources/assets/admin/app/subscriptions/subscription/subscription.component.scss")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_2_app_core_cycle_service__["a" /* CycleService */],
            __WEBPACK_IMPORTED_MODULE_3_app_core_subscription_service__["a" /* SubscriptionService */],
            __WEBPACK_IMPORTED_MODULE_1__angular_router__["a" /* ActivatedRoute */],
            __WEBPACK_IMPORTED_MODULE_1__angular_router__["c" /* Router */],
            __WEBPACK_IMPORTED_MODULE_4_app_core_snackbar_service__["a" /* SnackbarService */],
            __WEBPACK_IMPORTED_MODULE_6__angular_material__["d" /* MatDialog */]])
    ], SubscriptionComponent);
    return SubscriptionComponent;
}());



/***/ }),

/***/ "../../../../../resources/assets/admin/app/subscriptions/subscriptions.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"row page-heading\">\n  <h1 class=\"left\">Subscriptions</h1>\n  <a class=\"btn waves-light brand z-depth-0 right mt-md\" routerLink=\"/contacts/new\">\n    Add\n    <i class=\"material-icons right\">add</i>\n  </a>\n\n</div>\n\n<div class=\"pt-md\">\n  <div class=\"row\">\n\n    <div class=\"col s3 l2 xl2\">\n      <div class=\"card-panel stats-panel clearfix\">\n        <div class=\"col s12 title teal lighten-1\">\n          <h4>Total</h4>\n        </div>\n        <div class=\"col s12 stat\">\n          <h4>{{stats.total}}</h4>\n        </div>\n      </div>\n    </div>\n\n    <div class=\"col s3 l2 xl2\">\n      <div class=\"card-panel  stats-panel clearfix\">\n        <div class=\"col s12 title green lighten-1\">\n          <h4>Active</h4>\n        </div>\n        <div class=\"col s12 stat\">\n          <h4>{{stats.active}}</h4>\n        </div>\n      </div>\n    </div>\n\n    <div class=\"col s3 l2 xl2\">\n      <div class=\"card-panel stats-panel clearfix\">\n        <div class=\"col s12 title red lighten-1 \">\n          <h4>Inactive</h4>\n        </div>\n        <div class=\"col s12 stat\">\n          <h4>{{stats.inactive}}</h4>\n        </div>\n      </div>\n    </div>\n\n  </div>\n\n  <div class=\"row\">\n    <div class=\"col s12\">\n      <mat-card class=\"p-n\">\n        <mat-card-header class=\"p-sm\">\n\n          <div class=\"input-field col s12\">\n            <i class=\"material-icons prefix\">search</i>\n\n            <label for=\"query\">Search</label>\n            <input id=\"query\"\n                class=\"mb-n\"\n                (keyup)=\"applyFilter($event.target.value)\"\n                type=\"text\" />\n          </div>\n\n        </mat-card-header>\n\n        <mat-card-content>\n          <mat-table #table [dataSource]=\"subsData\" matSort>\n            <ng-container matColumnDef=\"status\">\n              <mat-header-cell *matHeaderCellDef mat-sort-header class=\"statusCell\">Status</mat-header-cell>\n              <mat-cell *matCellDef=\"let sub\" class=\"statusCell\">\n                <span class=\"circle\"\n                    [ngClass]=\"{'green': sub.isActive, 'red': !sub.isActive}\">\n                </span>\n              </mat-cell>\n            </ng-container>\n\n            <ng-container matColumnDef=\"company\">\n              <mat-header-cell *matHeaderCellDef mat-sort-header>Company</mat-header-cell>\n              <mat-cell *matCellDef=\"let sub\"> {{sub.company}} </mat-cell>\n            </ng-container>\n\n            <ng-container matColumnDef=\"contact\">\n              <mat-header-cell *matHeaderCellDef mat-sort-header>Contact</mat-header-cell>\n              <mat-cell *matCellDef=\"let sub\">\n                <a [routerLink]=\"['/contacts', sub?.baseAccount?.id]\">{{sub.baseAccount?.name}}</a>\n              </mat-cell>\n            </ng-container>\n\n            <ng-container matColumnDef=\"endDate\">\n              <mat-header-cell *matHeaderCellDef mat-sort-header>Expiration</mat-header-cell>\n              <mat-cell *matCellDef=\"let sub\">{{ sub.cycle?.ends_on | date:\"MMM Do, YYYY\" }} </mat-cell>\n            </ng-container>\n\n            <mat-header-row *matHeaderRowDef=\"columns\"></mat-header-row>\n            <mat-row *matRowDef=\"let sub; columns: columns\"\n                [id]=\"sub?.id\"\n                (click)=\"viewSubscription(sub.id)\">>\n            </mat-row>\n\n          </mat-table>\n        </mat-card-content>\n\n        <div class=\"progress\" [hidden]=\"!isLoading\">\n          <div class=\"indeterminate\"></div>\n        </div>\n\n      </mat-card>\n\n    </div>\n  </div>\n</div>\n"

/***/ }),

/***/ "../../../../../resources/assets/admin/app/subscriptions/subscriptions.component.scss":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("../../../../css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "mat-row {\n  cursor: pointer; }\n  mat-row:hover {\n    background: #fafafa; }\n\n.statusCell {\n  -webkit-box-flex: 0.3;\n      -ms-flex: 0.3;\n          flex: 0.3; }\n", ""]);

// exports


/*** EXPORTS FROM exports-loader ***/
module.exports = module.exports.toString();

/***/ }),

/***/ "../../../../../resources/assets/admin/app/subscriptions/subscriptions.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return SubscriptionsComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("../../../core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("../../../router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_material__ = __webpack_require__("../../../material/esm5/material.es5.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_app_core_subscription_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/subscription.service.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};




var SubscriptionsComponent = (function () {
    function SubscriptionsComponent(subscriptionService, router) {
        this.subscriptionService = subscriptionService;
        this.router = router;
        this.subsData = new __WEBPACK_IMPORTED_MODULE_2__angular_material__["k" /* MatTableDataSource */]();
        this.columns = ['status', 'company', 'contact', 'endDate'];
        this.stats = {
            total: 0,
            active: 0,
            inactive: 0,
        };
    }
    SubscriptionsComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.isLoading = true;
        this.subsData.sort = this.sort;
        this.subsData.filterPredicate = this.filterPredicate;
        this.subscriptionService.index()
            .share()
            .subscribe(function (subs) {
            _this.isLoading = false;
            _this.subsData.data = subs;
            _this.stats = {
                total: subs.length,
                active: subs.filter(function (s) { return s.isActive; }).length,
                inactive: subs.filter(function (u) { return !u.isActive; }).length,
            };
        });
    };
    SubscriptionsComponent.prototype.viewSubscription = function (subId) {
        this.router.navigate(['subscriptions', subId]);
    };
    SubscriptionsComponent.prototype.viewUser = function (userId) {
        this.router.navigate(['/contacts', userId]);
    };
    SubscriptionsComponent.prototype.filterPredicate = function (sub, filter) {
        var s = JSON.stringify(sub).trim().toLowerCase();
        var f = filter.toLowerCase();
        return s.includes(f);
    };
    SubscriptionsComponent.prototype.applyFilter = function (v) {
        this.subsData.filter = String(v).trim().toLowerCase();
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])(__WEBPACK_IMPORTED_MODULE_2__angular_material__["j" /* MatSort */]),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_2__angular_material__["j" /* MatSort */])
    ], SubscriptionsComponent.prototype, "sort", void 0);
    SubscriptionsComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'ctb-subscriptions',
            template: __webpack_require__("../../../../../resources/assets/admin/app/subscriptions/subscriptions.component.html"),
            styles: [__webpack_require__("../../../../../resources/assets/admin/app/subscriptions/subscriptions.component.scss")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_3_app_core_subscription_service__["a" /* SubscriptionService */],
            __WEBPACK_IMPORTED_MODULE_1__angular_router__["c" /* Router */]])
    ], SubscriptionsComponent);
    return SubscriptionsComponent;
}());



/***/ }),

/***/ "../../../../../resources/assets/admin/app/subscriptions/subscriptions.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SubscriptionsModule", function() { return SubscriptionsModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("../../../core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__subscriptions_component__ = __webpack_require__("../../../../../resources/assets/admin/app/subscriptions/subscriptions.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_app_shared_shared_module__ = __webpack_require__("../../../../../resources/assets/admin/app/shared/shared.module.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__angular_router__ = __webpack_require__("../../../router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__subscription_subscription_component__ = __webpack_require__("../../../../../resources/assets/admin/app/subscriptions/subscription/subscription.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__subscription_create_addon_modal_create_addon_modal_component__ = __webpack_require__("../../../../../resources/assets/admin/app/subscriptions/subscription/create-addon-modal/create-addon-modal.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__subscription_change_cycle_end_modal_component__ = __webpack_require__("../../../../../resources/assets/admin/app/subscriptions/subscription/change-cycle-end-modal.component.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};







var SubscriptionsModule = (function () {
    function SubscriptionsModule() {
    }
    SubscriptionsModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [
                __WEBPACK_IMPORTED_MODULE_2_app_shared_shared_module__["a" /* SharedModule */],
                __WEBPACK_IMPORTED_MODULE_3__angular_router__["d" /* RouterModule */].forChild([
                    { path: '', component: __WEBPACK_IMPORTED_MODULE_1__subscriptions_component__["a" /* SubscriptionsComponent */] },
                    { path: ':id', component: __WEBPACK_IMPORTED_MODULE_4__subscription_subscription_component__["a" /* SubscriptionComponent */] },
                ]),
            ],
            declarations: [
                __WEBPACK_IMPORTED_MODULE_1__subscriptions_component__["a" /* SubscriptionsComponent */],
                __WEBPACK_IMPORTED_MODULE_4__subscription_subscription_component__["a" /* SubscriptionComponent */],
                __WEBPACK_IMPORTED_MODULE_5__subscription_create_addon_modal_create_addon_modal_component__["a" /* CreateAddonModalComponent */],
                __WEBPACK_IMPORTED_MODULE_6__subscription_change_cycle_end_modal_component__["a" /* ChangeCycleEndModalComponent */]
            ],
            entryComponents: [
                __WEBPACK_IMPORTED_MODULE_5__subscription_create_addon_modal_create_addon_modal_component__["a" /* CreateAddonModalComponent */],
                __WEBPACK_IMPORTED_MODULE_6__subscription_change_cycle_end_modal_component__["a" /* ChangeCycleEndModalComponent */],
            ],
        })
    ], SubscriptionsModule);
    return SubscriptionsModule;
}());



/***/ })

});
//# sourceMappingURL=subscriptions.module.chunk.js.map