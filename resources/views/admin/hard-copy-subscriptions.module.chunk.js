webpackJsonp(["hard-copy-subscriptions.module"],{

/***/ "../../../../../resources/assets/admin/app/hard-copy-subscriptions/hard-copy-subscriptions.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"row page-heading\">\n  <h1 class=\"left\">Hard Copy Subscriptions</h1>\n</div>\n\n<div class=\"pt-md\">\n  <div class=\"row\">\n\n    <div class=\"col s3 l2 xl2\">\n      <div class=\"card-panel stats-panel clearfix\">\n        <div class=\"col s12 title teal lighten-1\">\n          <h4>Total</h4>\n        </div>\n        <div class=\"col s12 stat\">\n          <h4>{{stats.total}}</h4>\n        </div>\n      </div>\n    </div>\n\n    <div class=\"col s3 l2 xl2\">\n      <div class=\"card-panel  stats-panel clearfix\">\n        <div class=\"col s12 title green lighten-1\">\n          <h4>Active</h4>\n        </div>\n        <div class=\"col s12 stat\">\n          <h4>{{stats.active}}</h4>\n        </div>\n      </div>\n    </div>\n\n    <div class=\"col s3 l2 xl2\">\n      <div class=\"card-panel stats-panel clearfix\">\n        <div class=\"col s12 title red lighten-1 \">\n          <h4>Inactive</h4>\n        </div>\n        <div class=\"col s12 stat\">\n          <h4>{{stats.inactive}}</h4>\n        </div>\n      </div>\n    </div>\n\n  </div>\n\n  <div class=\"row\">\n    <div class=\"col s12\">\n      <mat-card class=\"p-n\">\n        <mat-card-header class=\"p-sm\">\n\n          <div class=\"input-field col s12\">\n            <i class=\"material-icons prefix\">search</i>\n\n            <label for=\"query\">Search</label>\n            <input id=\"query\"\n                class=\"mb-n\"\n                (keyup)=\"applyFilter($event.target.value)\"\n                type=\"text\" />\n          </div>\n\n        </mat-card-header>\n\n        <mat-card-content>\n          <mat-table #table [dataSource]=\"booksData\" matSort>\n            <ng-container matColumnDef=\"status\">\n              <mat-header-cell *matHeaderCellDef mat-sort-header class=\"statusCell\">Status</mat-header-cell>\n              <mat-cell *matCellDef=\"let row\" class=\"statusCell\">\n                <span class=\"circle\"\n                    [ngClass]=\"{'green': row.subscription?.isActive, 'red': !row.subscription?.isActive}\">\n                </span>\n              </mat-cell>\n            </ng-container>\n\n            <ng-container matColumnDef=\"company\">\n              <mat-header-cell *matHeaderCellDef mat-sort-header>Company</mat-header-cell>\n              <mat-cell *matCellDef=\"let row;\"> {{row.subscription?.company}} </mat-cell>\n            </ng-container>\n\n            <ng-container matColumnDef=\"address\">\n              <mat-header-cell *matHeaderCellDef mat-sort-header>Company</mat-header-cell>\n              <mat-cell *matCellDef=\"let row;\">\n                {{row.address?.line1}},\n                {{row.address?.line2 ? row.address?.line2 + ', ' : '' }}\n                {{row.address?.city}},\n                {{row.address?.state}}\n                {{row.address?.zip_code}}\n              </mat-cell>\n            </ng-container>\n\n            <mat-header-row *matHeaderRowDef=\"columns\"></mat-header-row>\n            <mat-row *matRowDef=\"let row; columns: columns\"\n                [id]=\"row.subscription_id\"\n                (click)=\"viewSubscription(row.subscription_id)\">>\n            </mat-row>\n\n          </mat-table>\n        </mat-card-content>\n\n        <div class=\"progress\" [hidden]=\"!isLoading\">\n          <div class=\"indeterminate\"></div>\n        </div>\n\n      </mat-card>\n\n    </div>\n  </div>\n</div>\n"

/***/ }),

/***/ "../../../../../resources/assets/admin/app/hard-copy-subscriptions/hard-copy-subscriptions.component.scss":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("../../../../css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".statusCell {\n  -webkit-box-flex: 0.3;\n      -ms-flex: 0.3;\n          flex: 0.3; }\n", ""]);

// exports


/*** EXPORTS FROM exports-loader ***/
module.exports = module.exports.toString();

/***/ }),

/***/ "../../../../../resources/assets/admin/app/hard-copy-subscriptions/hard-copy-subscriptions.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return HardCopySubscriptionsComponent; });
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




var HardCopySubscriptionsComponent = (function () {
    function HardCopySubscriptionsComponent(subscriptionService, router) {
        this.subscriptionService = subscriptionService;
        this.router = router;
        this.booksData = new __WEBPACK_IMPORTED_MODULE_2__angular_material__["k" /* MatTableDataSource */]();
        this.columns = ['status', 'company', 'address'];
        this.stats = {
            total: 0,
            active: 0,
            inactive: 0,
        };
    }
    HardCopySubscriptionsComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.isLoading = true;
        this.booksData.sort = this.sort;
        this.booksData.filterPredicate = this.filterPredicate;
        this.subscriptionService.indexHardCopies()
            .share()
            .subscribe(function (subs) {
            _this.isLoading = false;
            _this.booksData.data = subs;
            var active = subs.filter(function (book) { return book.subscription && book.subscription.isActive; }).length;
            _this.stats = {
                total: subs.length,
                active: active,
                inactive: subs.length - active,
            };
        });
    };
    HardCopySubscriptionsComponent.prototype.viewSubscription = function (subId) {
        this.router.navigate(['/subscriptions', subId]);
    };
    HardCopySubscriptionsComponent.prototype.filterPredicate = function (sub, filter) {
        var s = JSON.stringify(sub).trim().toLowerCase();
        var f = filter.toLowerCase();
        return s.includes(f);
    };
    HardCopySubscriptionsComponent.prototype.applyFilter = function (v) {
        this.booksData.filter = String(v).trim().toLowerCase();
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])(__WEBPACK_IMPORTED_MODULE_2__angular_material__["j" /* MatSort */]),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_2__angular_material__["j" /* MatSort */])
    ], HardCopySubscriptionsComponent.prototype, "sort", void 0);
    HardCopySubscriptionsComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'ctb-hard-copy-subscriptions',
            template: __webpack_require__("../../../../../resources/assets/admin/app/hard-copy-subscriptions/hard-copy-subscriptions.component.html"),
            styles: [__webpack_require__("../../../../../resources/assets/admin/app/hard-copy-subscriptions/hard-copy-subscriptions.component.scss")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_3_app_core_subscription_service__["a" /* SubscriptionService */],
            __WEBPACK_IMPORTED_MODULE_1__angular_router__["c" /* Router */]])
    ], HardCopySubscriptionsComponent);
    return HardCopySubscriptionsComponent;
}());



/***/ }),

/***/ "../../../../../resources/assets/admin/app/hard-copy-subscriptions/hard-copy-subscriptions.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "HardCopySubscriptionsModule", function() { return HardCopySubscriptionsModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("../../../core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("../../../router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_app_shared_shared_module__ = __webpack_require__("../../../../../resources/assets/admin/app/shared/shared.module.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__hard_copy_subscriptions_component__ = __webpack_require__("../../../../../resources/assets/admin/app/hard-copy-subscriptions/hard-copy-subscriptions.component.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};




var HardCopySubscriptionsModule = (function () {
    function HardCopySubscriptionsModule() {
    }
    HardCopySubscriptionsModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [
                __WEBPACK_IMPORTED_MODULE_2_app_shared_shared_module__["a" /* SharedModule */],
                __WEBPACK_IMPORTED_MODULE_1__angular_router__["d" /* RouterModule */].forChild([
                    { path: '', component: __WEBPACK_IMPORTED_MODULE_3__hard_copy_subscriptions_component__["a" /* HardCopySubscriptionsComponent */] },
                ])
            ],
            declarations: [__WEBPACK_IMPORTED_MODULE_3__hard_copy_subscriptions_component__["a" /* HardCopySubscriptionsComponent */]]
        })
    ], HardCopySubscriptionsModule);
    return HardCopySubscriptionsModule;
}());



/***/ })

});
//# sourceMappingURL=hard-copy-subscriptions.module.chunk.js.map