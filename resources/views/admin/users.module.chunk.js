webpackJsonp(["users.module"],{

/***/ "../../../../../resources/assets/admin/app/users/users.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"row page-heading\">\n  <h1 class=\"left\">Contacts</h1>\n\n</div>\n\n<div class=\"pt-md\">\n  <div class=\"row\">\n\n    <div class=\"col s3 l2 xl2\">\n      <div class=\"card-panel stats-panel clearfix\">\n        <div class=\"col s12 title teal lighten-1\">\n          <h4>Total</h4>\n        </div>\n        <div class=\"col s12 stat\">\n          <h4>{{stats.total}}</h4>\n        </div>\n      </div>\n    </div>\n\n    <div class=\"col s3 l2 xl2\">\n      <div class=\"card-panel  stats-panel clearfix\">\n        <div class=\"col s12 title green lighten-1\">\n          <h4>Active</h4>\n        </div>\n        <div class=\"col s12 stat\">\n          <h4>{{stats.active}}</h4>\n        </div>\n      </div>\n    </div>\n\n    <div class=\"col s3 l2 xl2\">\n      <div class=\"card-panel stats-panel clearfix\">\n        <div class=\"col s12 title red lighten-1 \">\n          <h4>Inactive</h4>\n        </div>\n        <div class=\"col s12 stat\">\n          <h4>{{stats.inactive}}</h4>\n        </div>\n      </div>\n    </div>\n\n  </div>\n\n  <div class=\"row\">\n    <div class=\"col s12\">\n      <mat-card class=\"p-n\">\n        <mat-card-header class=\"p-sm\">\n\n          <div class=\"input-field col s12\">\n            <i class=\"material-icons prefix\">search</i>\n\n            <label for=\"query\">Search</label>\n            <input id=\"query\"\n              class=\"mb-n\"\n              (keyup)=\"applyFilter($event.target.value)\"\n              type=\"text\" />\n          </div>\n\n        </mat-card-header>\n\n        <mat-card-content>\n          <mat-table #table [dataSource]=\"usersData\" matSort>\n            <ng-container matColumnDef=\"status\">\n              <mat-header-cell *matHeaderCellDef mat-sort-header class=\"statusCell\">Status</mat-header-cell>\n              <mat-cell *matCellDef=\"let user\" class=\"statusCell\">\n                <span class=\"circle\"\n                  [ngClass]=\"{'green': user.hasActiveSubscription, 'red': !user.hasActiveSubscription}\">\n                </span>\n              </mat-cell>\n            </ng-container>\n\n            <ng-container matColumnDef=\"name\">\n              <mat-header-cell *matHeaderCellDef mat-sort-header> Name </mat-header-cell>\n              <mat-cell *matCellDef=\"let user\"> {{user.name}} </mat-cell>\n            </ng-container>\n\n            <ng-container matColumnDef=\"email\">\n              <mat-header-cell *matHeaderCellDef mat-sort-header> Email </mat-header-cell>\n              <mat-cell *matCellDef=\"let user\">\n                <a [href]=\"'mailto:' + user.email\">{{user.email}}</a>\n              </mat-cell>\n            </ng-container>\n\n            <ng-container matColumnDef=\"company\">\n              <mat-header-cell *matHeaderCellDef mat-sort-header> Company </mat-header-cell>\n              <mat-cell *matCellDef=\"let user\"> {{user.company}} </mat-cell>\n            </ng-container>\n\n            <ng-container matColumnDef=\"subscribedOn\">\n              <mat-header-cell *matHeaderCellDef mat-sort-header> Subscribed On </mat-header-cell>\n              <mat-cell *matCellDef=\"let user\"> {{user.subscribedOn}} </mat-cell>\n            </ng-container>\n\n            <mat-header-row *matHeaderRowDef=\"columns\"></mat-header-row>\n            <mat-row *matRowDef=\"let user; columns: columns\"\n                [id]=\"user?.id\"\n                (click)=\"viewUser(user.id)\">>\n            </mat-row>\n\n          </mat-table>\n        </mat-card-content>\n\n        <div class=\"progress\" [hidden]=\"!(isLoading$ | async)\">\n          <div class=\"indeterminate\"></div>\n        </div>\n\n      </mat-card>\n\n    </div>\n  </div>\n</div>"

/***/ }),

/***/ "../../../../../resources/assets/admin/app/users/users.component.scss":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("../../../../css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "mat-row {\n  cursor: pointer; }\n  mat-row:hover {\n    background: #fafafa; }\n\n.statusCell {\n  -webkit-box-flex: 0.3;\n      -ms-flex: 0.3;\n          flex: 0.3; }\n", ""]);

// exports


/*** EXPORTS FROM exports-loader ***/
module.exports = module.exports.toString();

/***/ }),

/***/ "../../../../../resources/assets/admin/app/users/users.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return UsersComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("../../../core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("../../../router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_app_core_user_service__ = __webpack_require__("../../../../../resources/assets/admin/app/core/user.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__angular_material__ = __webpack_require__("../../../material/esm5/material.es5.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};




var UsersComponent = (function () {
    function UsersComponent(userService, router) {
        this.userService = userService;
        this.router = router;
        this.usersData = new __WEBPACK_IMPORTED_MODULE_3__angular_material__["k" /* MatTableDataSource */]();
        this.stats = {
            total: 0,
            active: 0,
            inactive: 0,
        };
        this.columns = ['status', 'name', 'email', 'company', 'subscribedOn'];
        this.isLoading$ = userService.isLoading$;
    }
    UsersComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.usersData.sort = this.sort;
        this.userService.get()
            .share()
            .subscribe(function (users) {
            _this.usersData.data = users;
            _this.stats = {
                total: users.length,
                active: users.filter(function (u) { return u.hasActiveSubscription; }).length,
                inactive: users.filter(function (u) { return !u.hasActiveSubscription; }).length,
            };
        });
    };
    UsersComponent.prototype.viewUser = function (userId) {
        this.router.navigate(['/contacts', userId]);
    };
    UsersComponent.prototype.applyFilter = function (v) {
        this.usersData.filter = String(v).trim().toLowerCase();
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])(__WEBPACK_IMPORTED_MODULE_3__angular_material__["j" /* MatSort */]),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_3__angular_material__["j" /* MatSort */])
    ], UsersComponent.prototype, "sort", void 0);
    UsersComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'ctb-users',
            template: __webpack_require__("../../../../../resources/assets/admin/app/users/users.component.html"),
            styles: [__webpack_require__("../../../../../resources/assets/admin/app/users/users.component.scss")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_2_app_core_user_service__["a" /* UserService */],
            __WEBPACK_IMPORTED_MODULE_1__angular_router__["c" /* Router */]])
    ], UsersComponent);
    return UsersComponent;
}());



/***/ }),

/***/ "../../../../../resources/assets/admin/app/users/users.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "UsersModule", function() { return UsersModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("../../../core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("../../../router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_app_shared_shared_module__ = __webpack_require__("../../../../../resources/assets/admin/app/shared/shared.module.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_app_users_users_component__ = __webpack_require__("../../../../../resources/assets/admin/app/users/users.component.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};




var UsersModule = (function () {
    function UsersModule() {
    }
    UsersModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [
                __WEBPACK_IMPORTED_MODULE_2_app_shared_shared_module__["a" /* SharedModule */],
                __WEBPACK_IMPORTED_MODULE_1__angular_router__["d" /* RouterModule */].forChild([
                    { path: '', component: __WEBPACK_IMPORTED_MODULE_3_app_users_users_component__["a" /* UsersComponent */] },
                    { path: 'new', loadChildren: './user-create/user-create.module#UserCreateModule' },
                    { path: ':id', loadChildren: './user/user.module#UserModule' },
                ]),
            ],
            declarations: [__WEBPACK_IMPORTED_MODULE_3_app_users_users_component__["a" /* UsersComponent */]]
        })
    ], UsersModule);
    return UsersModule;
}());



/***/ })

});
//# sourceMappingURL=users.module.chunk.js.map