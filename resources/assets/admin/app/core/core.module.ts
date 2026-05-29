import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { UserService } from './user.service';
import { TokenInterceptor } from './token.interceptor';
import { CycleService } from 'app/core/cycle.service';
import { SnackbarService } from 'app/core/snackbar.service';
import { SubscriptionService } from './subscription.service';
import { CompanyService } from './company.service';

@NgModule({
  imports: [
    CommonModule,
    HttpClientModule,
    BrowserAnimationsModule,
  ],
  providers: [
    UserService,
    SubscriptionService,
    CycleService,
    CompanyService,
    SnackbarService,
    {
      provide: HTTP_INTERCEPTORS,
      useClass: TokenInterceptor,
      multi: true,
    }
  ]
})
export class CoreModule { }
