import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { SharedModule } from 'app/shared/shared.module';
import { HardCopySubscriptionsComponent } from './hard-copy-subscriptions.component';

@NgModule({
  imports: [
    SharedModule,
      RouterModule.forChild([
        { path: '', component: HardCopySubscriptionsComponent },
      ])
  ],
  declarations: [HardCopySubscriptionsComponent]
})
export class HardCopySubscriptionsModule { }
