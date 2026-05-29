webpackJsonp(["user.module"],{

/***/ "../../../../../resources/assets/admin/app/users/user/change-user-password-modal/change-user-password-modal.component.html":
/***/ (function(module, exports) {

module.exports = "\n\n<form [formGroup]=\"passwordForm\"\n    (submit)=\"onSubmit(passwordForm)\">\n  <h3 mat-dialog-title>\n    Change Subscriber Password\n    <small>{{ user.name }}</small>\n  </h3>\n  <mat-dialog-content>\n    <div class=\"input-field col m12\">\n      <label for=\"password\">Password</label>\n      <input id=\"password\"\n          formControlName=\"password\"\n          required\n          [ngClass]=\"{'valid': isValid('password'), 'invalid': isInvalid('password')}\"\n          type=\"password\" />\n\n      <div *ngIf=\"get('password').errors && isInvalid('password')\">\n        <p class=\"error\" *ngIf=\"get('password').errors.required\">This field is required.</p>\n        <p class=\"error\" *ngIf=\"get('password').errors.server\" [innerHtml]=\"get('password').errors.server.join('<br/>')\"></p>\n      </div>\n    </div>\n\n    <div class=\"input-field col m12\">\n      <label for=\"password_confirmation\">Confirm Password</label>\n      <input id=\"password_confirmation\"\n          formControlName=\"password_confirmation\"\n          required\n          [ngClass]=\"{'valid': isValid('password_confirmation'), 'invalid': isInvalid('password_confirmation')}\"\n          type=\"password\" />\n\n      <div *ngIf=\"get('password_confirmation').errors && isInvalid('password_confirmation')\">\n        <p class=\"error\" *ngIf=\"get('password_confirmation').errors.required\">This field is required.</p>\n        <p class=\"error\" *ngIf=\"get('password_confirmation').errors.server\" [innerHtml]=\"get('password_confirmation').errors.server.join('<br/>')\"></p>\n      </div>\n    </div>\n\n\n  </mat-dialog-content>\n\n  <mat-dialog-actions>\n\n      <button mat-button mat-dialog-close class=\"btn z-depth-0 waves-effect waves-light blue-grey lighten-5 blue-grey-text left\"\n          (click)=\"cancel()\"\n          type=\"submit\">\n        Cancel\n      </button>\n\n      <ctb-loader class=\"right\" classes=\"small\" *ngIf=\"formIsLoading\"></ctb-loader>\n      <button mat-button type=\"submit\"\n          [disabled]=\"passwordForm.invalid || formIsLoading\"\n          class=\"waves-effect waves-light btn right right\">\n        Submit\n      </button>\n\n  </mat-dialog-actions>\n\n</form>\n"

/***/ }),

/***/ "../../../../../resources/assets/admin/app/users/user/change-user-password-modal/change-user-password-modal.component.scss":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("../../../../css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".mat-dialog-actions {\n  -webkit-box-pack: justify;\n      -ms-flex-pack: justify;\n          justify-content: space-between; }\n", ""]);

// exports


/*** EXPORTS FROM exports-loader ***/
module.exports = module.exports.toString();

/***/ }),

/***/ "../../../../../resources/assets/admin/app/users/user/change-user-password-modal/change-user-password-modal.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ChangeUserPasswordModalComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("../../../core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_forms__ = __webpack_require__("../../../forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_app_core_snackbar_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/snackbar.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__core_user_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/user.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__angular_material__ = __webpack_require__("../../../material/esm5/material.es5.js");
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





var ChangeUserPasswordModalComponent = (function () {
    function ChangeUserPasswordModalComponent(dialogRef, fb, userService, snackbar, data) {
        this.dialogRef = dialogRef;
        this.fb = fb;
        this.userService = userService;
        this.snackbar = snackbar;
        this.data = data;
        this.passwordForm = fb.group({
            password: ['', [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].minLength(6)]],
            password_confirmation: ['', [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].minLength(6)]],
        });
    }
    ChangeUserPasswordModalComponent.prototype.ngOnInit = function () {
        this.user = this.data.user;
    };
    ChangeUserPasswordModalComponent.prototype.cancel = function () {
        this.dialogRef.close();
    };
    ChangeUserPasswordModalComponent.prototype.onNoClick = function () {
        this.cancel();
    };
    ChangeUserPasswordModalComponent.prototype.onSubmit = function (form) {
        var _this = this;
        this.submitted = true;
        if (form.invalid)
            return false;
        this.formIsLoading = true;
        this.userService.updatePassword(this.user.id, form.value)
            .subscribe(function (user) {
            console.log(user);
            _this.formIsLoading = false;
            _this.snackbar.snack('Subscriber password updated successfully.');
            _this.dialogRef.close();
        }, function (res) {
            _this.formIsLoading = false;
            _this.snackbar.error('There are some form errors.');
            _this.passwordForm.markAsPristine();
            Object.keys(res.error.errors)
                .map(function (k) {
                _this.passwordForm.get(k)
                    .setErrors({ server: res.error.errors[k] });
            });
        });
    };
    ChangeUserPasswordModalComponent.prototype.isValid = function (field) {
        var c;
        if (field instanceof __WEBPACK_IMPORTED_MODULE_1__angular_forms__["a" /* AbstractControl */]) {
            c = field;
        }
        else {
            c = this.passwordForm.get(field);
        }
        return c.valid;
    };
    ChangeUserPasswordModalComponent.prototype.isInvalid = function (field) {
        var c;
        if (field instanceof __WEBPACK_IMPORTED_MODULE_1__angular_forms__["a" /* AbstractControl */]) {
            c = field;
        }
        else {
            c = this.passwordForm.get(field);
        }
        return c.invalid && (c.dirty || c.touched || this.submitted);
    };
    ChangeUserPasswordModalComponent.prototype.get = function (field) {
        return this.passwordForm.get(field);
    };
    ChangeUserPasswordModalComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'ctb-change-user-password-modal',
            template: __webpack_require__("../../../../../resources/assets/admin/app/users/user/change-user-password-modal/change-user-password-modal.component.html"),
            styles: [__webpack_require__("../../../../../resources/assets/admin/app/users/user/change-user-password-modal/change-user-password-modal.component.scss")]
        }),
        __param(4, Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Inject"])(__WEBPACK_IMPORTED_MODULE_4__angular_material__["a" /* MAT_DIALOG_DATA */])),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_4__angular_material__["e" /* MatDialogRef */],
            __WEBPACK_IMPORTED_MODULE_1__angular_forms__["d" /* FormBuilder */],
            __WEBPACK_IMPORTED_MODULE_3__core_user_service__["a" /* UserService */],
            __WEBPACK_IMPORTED_MODULE_2_app_core_snackbar_service__["a" /* SnackbarService */], Object])
    ], ChangeUserPasswordModalComponent);
    return ChangeUserPasswordModalComponent;
}());



/***/ }),

/***/ "../../../../../resources/assets/admin/app/users/user/user.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"row page-heading\">\n  <h1>\n    Subscriber\n    <small>{{ (user$ | async)?.name }}</small>\n  </h1>\n</div>\n\n<div>\n\n  <div class=\"row\" [hidden]=\"user$ | async\">\n    <div class=\"preloader-wrapper active m-auto fn block\">\n      <div class=\"spinner-layer spinner-red-only\">\n        <div class=\"circle-clipper left\">\n          <div class=\"circle\"></div>\n        </div><div class=\"gap-patch\">\n          <div class=\"circle\"></div>\n        </div><div class=\"circle-clipper right\">\n          <div class=\"circle\"></div>\n        </div>\n      </div>\n    </div>\n\n  </div>\n\n  <div [hidden]=\"!(user$ | async)\">\n\n    <div class=\"row\">\n      <div class=\"col s12\">\n        <div class=\"ctb-title\">\n          <h4>Account</h4>\n        </div>\n        <div class=\"card account-card\">\n          <form class=\"form\"\n            action=\"javascript:void(0);\"\n            [formGroup]=\"accountForm\"\n            (submit)=\"onAccountFormSubmit(accountForm)\">\n            <div *ngIf=\"user$ | async; let user\" class=\"card-content\">\n              <table class=\"bordered responsive-table m-n\">\n                <tbody>\n                  <tr>\n                    <th>Name</th>\n                    <td>\n                      <ng-container>\n                        <div *ngIf=\"editingAccount; then nameEdit else nameDisplay\"></div>\n                        <ng-template #nameDisplay>\n                            {{ user.name }}\n                        </ng-template>\n                        <ng-template #nameEdit>\n                          <input type=\"text\"\n                            placeholder=\"Name\"\n                            formControlName=\"name\"\n                            required />\n                        </ng-template>\n                      </ng-container>\n                    </td>\n                    <th>Email</th>\n                    <td>\n                      <ng-container>\n                        <div *ngIf=\"editingAccount; then emailEdit else emailDisplay\"></div>\n                        <ng-template #emailDisplay>\n                          <a [href]=\"'mailto:' + user.email\">\n                            {{ user.email }}\n                          </a>\n                        </ng-template>\n                        <ng-template #emailEdit>\n                          <input type=\"email\"\n                            placeholder=\"Email\"\n                            formControlName=\"email\"\n                            required />\n                        </ng-template>\n                      </ng-container>\n                    </td>\n                  </tr>\n                  <tr>\n                    <th>Password</th>\n                    <td>\n                      <span *ngIf=\"user.has_password\">******</span>\n                      <i *ngIf=\"!user.has_password\">None Set</i>\n\n                      <a (click)=\"changePassword()\">\n                        <i class=\"material-icons right\">mode_edit</i>\n                      </a>\n                    </td>\n                    <td></td>\n                    <td></td>\n                  </tr>\n                  <tr>\n                    <th>Subscribed On</th>\n                    <td>{{ user.subscribedOn }} </td>\n                    <th>Account Type</th>\n                    <td class=\"capitalize\">\n                      <ng-container>\n                        <div *ngIf=\"editingAccount; then roleEdit else roleDisplay\"></div>\n                        <ng-template #roleDisplay>\n                          {{ user.role }}\n                        </ng-template>\n                        <ng-template #roleEdit>\n                          <mat-form-field>\n                            <mat-select formControlName=\"role\">\n                              <mat-option value=\"subscriber\">Subscriber</mat-option>\n                              <mat-option value=\"editor\">Editor</mat-option>\n                              <mat-option value=\"admin\">Admin</mat-option>\n                            </mat-select>\n                          </mat-form-field>\n                        </ng-template>\n                      </ng-container>\n\n                    </td>\n                  </tr>\n\n                  <tr>\n                    <th>Company</th>\n                    <td>\n                      <ng-container>\n                        <div *ngIf=\"editingAccount; then companyEdit else companyDisplay\"></div>\n                        <ng-template #companyDisplay>\n                          {{ user.company }}\n                        </ng-template>\n                        <ng-template #companyEdit>\n                          <input type=\"text\"\n                            placeholder=\"Company\"\n                            formControlName=\"company\" />\n                        </ng-template>\n                      </ng-container>\n                    </td>\n                    <th>Phone Number</th>\n                    <td>\n                      <ng-container>\n                        <div *ngIf=\"editingAccount; then phoneNumberEdit else phoneNumberDisplay\"></div>\n                        <ng-template #phoneNumberDisplay>\n                          {{ user.phone_number }}\n                        </ng-template>\n                        <ng-template #phoneNumberEdit>\n                          <input type=\"text\"\n                            placeholder=\"Phone #\"\n                            formControlName=\"phoneNumber\" />\n                        </ng-template>\n                      </ng-container>\n                    </td>\n                  </tr>\n\n                  <tr>\n                    <th>Stripe Customer ID</th>\n                    <td>\n                      <a [href]=\"user.stripe_id | stripeLink\" target=\"_blank\">\n                        {{ user.stripe_id }}\n                      </a>\n                    </td>\n                    <th>Account Id</th>\n                    <td>{{ user.id }} </td>\n                  </tr>\n\n                  <tr *ngIf=\"user.subscriptions[0]\">\n                    <th>Subscription ID</th>\n                    <td>\n                      <a [routerLink]=\"['/subscriptions', user.subscriptions[0].id]\" >\n                        {{ user.subscriptions[0].id }}\n                      </a>\n                    </td>\n                  </tr>\n\n                </tbody>\n              </table>\n              <table>\n                <tr>\n                  <th>Notes</th>\n                </tr>\n                <tr>\n                  <td class=\"pt-n pb-n\">\n                    <ng-container>\n                      <div *ngIf=\"editingAccount; then notesEdit else notesDisplay\"></div>\n                      <ng-template #notesDisplay>\n                        <p class=\"keep-whitespace\">\n                          {{ user.notes }}\n                        </p>\n                      </ng-template>\n                      <ng-template #notesEdit>\n                        <textarea formControlName=\"notes\"\n                          class=\"materialize-textarea\"\n                          placeholder=\"Subscriber Notes\">\n                        </textarea>\n                      </ng-template>\n                    </ng-container>\n\n                  </td>\n                </tr>\n              </table>\n            </div>\n\n            <div class=\"card-action right-align\">\n              <button class=\"btn z-depth-0 waves-effect waves-light blue-grey lighten-5 blue-grey-text left\"\n                *ngIf=\"editingAccount\"\n                (click)=\"editingAccount = false\"\n                type=\"submit\">\n                Cancel\n              </button>\n\n              <button class=\"btn waves-effect waves-light\"\n                *ngIf=\"!editingAccount\"\n                (click)=\"editingAccount = true\"\n                type=\"button\">\n                Edit\n                <i class=\"material-icons right\">mode_edit</i>\n              </button>\n\n              <ctb-loader classes=\"small\" *ngIf=\"accountFormLoading\"></ctb-loader>\n              <button class=\"btn waves-effect waves-light\"\n                *ngIf=\"editingAccount\"\n                [disabled]=\"accountForm.invalid || accountFormLoading\"\n                type=\"submit\">\n                Save\n              </button>\n            </div>\n          </form>\n\n\n        </div>\n      </div>\n    </div>\n\n  </div>\n</div>\n"

/***/ }),

/***/ "../../../../../resources/assets/admin/app/users/user/user.component.scss":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("../../../../css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".go-arrow {\n  position: absolute;\n  right: 20px;\n  top: 50%;\n  -webkit-transform: translateY(-50%);\n          transform: translateY(-50%); }\n\n.address p {\n  margin: 0; }\n\n.cycles .collection-item {\n  border-left: 5px solid #b23c3c; }\n  .cycles .collection-item a {\n    cursor: pointer; }\n  .cycles .collection-item.active-cycle {\n    border-left-color: #4caf50; }\n\n.account-card input {\n  margin: 0;\n  padding: 5px;\n  height: auto; }\n\ninput {\n  width: auto !important; }\n", ""]);

// exports


/*** EXPORTS FROM exports-loader ***/
module.exports = module.exports.toString();

/***/ }),

/***/ "../../../../../resources/assets/admin/app/users/user/user.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return UserComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("../../../core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_forms__ = __webpack_require__("../../../forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_router__ = __webpack_require__("../../../router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_app_core_user_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/user.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_app_core_cycle_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/cycle.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_app_core_snackbar_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/snackbar.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__change_user_password_modal_change_user_password_modal_component__ = __webpack_require__("../../../../../resources/assets/admin/app/users/user/change-user-password-modal/change-user-password-modal.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__angular_material__ = __webpack_require__("../../../material/esm5/material.es5.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};








var UserComponent = (function () {
    function UserComponent(userService, route, router, cycleService, snackbar, fb, dialog) {
        this.userService = userService;
        this.route = route;
        this.router = router;
        this.cycleService = cycleService;
        this.snackbar = snackbar;
        this.fb = fb;
        this.dialog = dialog;
        this.router.onSameUrlNavigation = 'reload';
        this.router.routeReuseStrategy.shouldReuseRoute = function () { return false; };
        this.accountForm = this.fb.group({
            name: ['', [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required]],
            email: ['', [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required, __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].email]],
            company: [''],
            phoneNumber: [''],
            role: [''],
            notes: [''],
        });
    }
    UserComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.route.params.subscribe(function (params) {
            _this.userId = params.id;
            _this.user$ = _this.userService.getById(params.id)
                .do(function (u) {
                _this.user = u;
                // patch edit forms
                _this.accountForm.patchValue({
                    name: u.name,
                    email: u.email,
                    company: u.company,
                    phoneNumber: u.phone_number,
                    role: u.role,
                    notes: u.notes,
                });
            })
                .share();
        });
    };
    UserComponent.prototype.onAccountFormSubmit = function (form) {
        var _this = this;
        if (form.invalid)
            return;
        this.accountFormLoading = false;
        var edits = Object.keys(form.value)
            .filter(function (k) { return form.value[k] !== _this.user[k]; })
            .reduce(function (e, k) {
            e[k] = form.value[k];
            return e;
        }, {});
        if (edits.name) {
            var name_1 = edits.name.trim().split(' ');
            edits.first_name = name_1.splice(0, 1)[0];
            edits.last_name = name_1.join(' ');
            delete edits.name;
        }
        console.log(edits);
        this.userService.update(this.userId, edits)
            .subscribe(function (user) {
            _this.accountFormLoading = false;
            _this.editingAccount = false;
            _this.snackbar.snack('Subscriber updated successfully.');
        }, function (res) {
            var errors = Object.keys(res.error.errors)
                .reduce(function (e, k) { return e.concat(res.error.errors[k]); }, []);
            _this.snackbar.error(errors.join('\n'));
        });
    };
    UserComponent.prototype.changePassword = function () {
        var dialogRef = this.dialog.open(__WEBPACK_IMPORTED_MODULE_6__change_user_password_modal_change_user_password_modal_component__["a" /* ChangeUserPasswordModalComponent */], {
            height: '370px',
            width: '400px',
            data: { user: this.user },
        });
    };
    UserComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'ctb-user',
            template: __webpack_require__("../../../../../resources/assets/admin/app/users/user/user.component.html"),
            styles: [__webpack_require__("../../../../../resources/assets/admin/app/users/user/user.component.scss")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_3_app_core_user_service__["a" /* UserService */],
            __WEBPACK_IMPORTED_MODULE_2__angular_router__["a" /* ActivatedRoute */],
            __WEBPACK_IMPORTED_MODULE_2__angular_router__["c" /* Router */],
            __WEBPACK_IMPORTED_MODULE_4_app_core_cycle_service__["a" /* CycleService */],
            __WEBPACK_IMPORTED_MODULE_5_app_core_snackbar_service__["a" /* SnackbarService */],
            __WEBPACK_IMPORTED_MODULE_1__angular_forms__["d" /* FormBuilder */],
            __WEBPACK_IMPORTED_MODULE_7__angular_material__["d" /* MatDialog */]])
    ], UserComponent);
    return UserComponent;
}());



/***/ }),

/***/ "../../../../../resources/assets/admin/app/users/user/user.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "UserModule", function() { return UserModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("../../../core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("../../../router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_forms__ = __webpack_require__("../../../forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_app_shared_shared_module__ = __webpack_require__("../../../../../resources/assets/admin/app/shared/shared.module.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_app_users_user_user_component__ = __webpack_require__("../../../../../resources/assets/admin/app/users/user/user.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__change_user_password_modal_change_user_password_modal_component__ = __webpack_require__("../../../../../resources/assets/admin/app/users/user/change-user-password-modal/change-user-password-modal.component.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};






var UserModule = (function () {
    function UserModule() {
    }
    UserModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [
                __WEBPACK_IMPORTED_MODULE_3_app_shared_shared_module__["a" /* SharedModule */],
                __WEBPACK_IMPORTED_MODULE_2__angular_forms__["k" /* ReactiveFormsModule */],
                __WEBPACK_IMPORTED_MODULE_1__angular_router__["d" /* RouterModule */].forChild([{ path: '', component: __WEBPACK_IMPORTED_MODULE_4_app_users_user_user_component__["a" /* UserComponent */] }])
            ],
            declarations: [__WEBPACK_IMPORTED_MODULE_4_app_users_user_user_component__["a" /* UserComponent */], __WEBPACK_IMPORTED_MODULE_5__change_user_password_modal_change_user_password_modal_component__["a" /* ChangeUserPasswordModalComponent */]],
            entryComponents: [__WEBPACK_IMPORTED_MODULE_5__change_user_password_modal_change_user_password_modal_component__["a" /* ChangeUserPasswordModalComponent */]],
        })
    ], UserModule);
    return UserModule;
}());



/***/ })

});
//# sourceMappingURL=user.module.chunk.js.map