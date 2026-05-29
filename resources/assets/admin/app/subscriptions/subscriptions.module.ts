import { NgModule } from '@angular/core';
import { SubscriptionsComponent } from './subscriptions.component';
import { SharedModule } from 'app/shared/shared.module';
import { RouterModule } from '@angular/router';
import { SubscriptionComponent } from './subscription/subscription.component';
import { CreateAddonModalComponent } from './subscription/create-addon-modal/create-addon-modal.component';
import { RemoveAddonModalComponent } from './subscription/remove-addon-modal.component';
import { CyclesTableComponent } from './subscription/cycles-table/cycles-table.component';
import { EditCycleModalComponent } from './subscription/cycles-table/edit-cycle-modal.component';
import { MarkCyclePaidComponent } from './subscription/cycles-table/mark-cycle-paid.component';
import { CreateRenewalModalComponent } from './subscription/create-renewal-modal/create-renewal-modal.component';
import { EditCompanyModalComponent } from './subscription/edit-company-modal/edit-company-modal.component';
import { RemoveBookSubscriptionModalComponent } from './subscription/remove-book-subscription-modal.component';
import { EditHardCopyModalComponent } from './subscription/edit-hard-copy-modal/edit-hard-copy-modal.component';

@NgModule({
  imports: [
    SharedModule,
    RouterModule.forChild([
      { path: '', component: SubscriptionsComponent },
      { path: ':id', component: SubscriptionComponent },
    ]),
  ],
  declarations: [
    SubscriptionsComponent,
    SubscriptionComponent,
    CreateAddonModalComponent,
    RemoveAddonModalComponent,
    CyclesTableComponent,
    EditCycleModalComponent,
    MarkCyclePaidComponent,
    CreateRenewalModalComponent,
    EditCompanyModalComponent,
    EditHardCopyModalComponent,
    RemoveBookSubscriptionModalComponent,
  ],
  entryComponents: [
    CreateAddonModalComponent,
    CreateRenewalModalComponent,
    RemoveAddonModalComponent,
    EditCycleModalComponent,
    EditCompanyModalComponent,
    EditHardCopyModalComponent,
    RemoveBookSubscriptionModalComponent,
  ],
})
export class SubscriptionsModule {
}
