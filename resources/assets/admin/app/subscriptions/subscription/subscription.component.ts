import { Component, OnInit, ViewChild } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

import { Observable } from 'rxjs/Observable';

import { Subscription } from 'models/subscription';
import { CycleService } from 'app/core/cycle.service';
import { SubscriptionService } from 'app/core/subscription.service';
import { SnackbarService } from 'app/core/snackbar.service';
import { CreateAddonModalComponent } from './create-addon-modal/create-addon-modal.component';
import { MatDialog } from '@angular/material';
import { User } from '../../../models/user';
import { RemoveAddonModalComponent } from './remove-addon-modal.component';
import { filter, switchMap } from 'rxjs/operators';
import { CreateRenewalModalComponent } from './create-renewal-modal/create-renewal-modal.component';
import { EditCompanyModalComponent } from './edit-company-modal/edit-company-modal.component';
import { BookSubscription } from '../../../models/book-subscription';
import { RemoveBookSubscriptionModalComponent } from './remove-book-subscription-modal.component';
import { EditHardCopyModalComponent } from './edit-hard-copy-modal/edit-hard-copy-modal.component';

@Component({
  selector: 'ctb-subscription',
  templateUrl: './subscription.component.html',
  styleUrls: ['./subscription.component.scss']
})
export class SubscriptionComponent implements OnInit {

  subId: number;
  sub$: Observable<Subscription>;
  sub: Subscription;
  showPastCycles: boolean;
  loadingMarkPaid: boolean;

  constructor(private cycleService: CycleService,
              private subscriptionService: SubscriptionService,
              private route: ActivatedRoute,
              private router: Router,
              private snackbar: SnackbarService,
              private dialog: MatDialog,) {
    this.router.onSameUrlNavigation = 'reload';
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
  }

  ngOnInit() {

    this.route.params.subscribe(params => {
      this.subId = params.id;

      this.sub$ = this.subscriptionService.get(this.subId)
          .map(sub => {
            if (sub.inactiveCycles) {
              sub.inactiveCycles.forEach(c => {
                c.isPending = !c.starts_on && !c.ends_on;
              });
            }
            this.sub = sub;
            return sub;
          })
        .share();
    });
  }

  editCompany(sub: Subscription) {
    const dialogRef = this.dialog.open(EditCompanyModalComponent, {
      width: '400px',
      data: { company: sub.company },
    });

    dialogRef.beforeClose()
      .filter(update => !!update)
      .subscribe(company => Object.assign(this.sub, { company }));
  }

  createAddon() {
    const dialogRef = this.dialog.open(CreateAddonModalComponent, {
      width: '400px',
      data: { subscriptionId: this.subId },
    });

  }

  removeAddon(user: User) {
    const dialogRef = this.dialog.open(RemoveAddonModalComponent, {
      width: '400px',
      data: { user, company: this.sub.company.name },
    });

    dialogRef.beforeClose()
        .pipe(
            filter(doRemove => !!doRemove),
            switchMap(() => this.subscriptionService.removeAddon(this.subId, user.id)),
        )
        .subscribe(
            () => this.snackbar.snack('Addon was removed from the subscription.'),
            e => {
              console.log(e);
              this.snackbar.error('Could not remove addon.');
            }
        );

  }

  createRenewal(subscription: Subscription) {
    const dialogRef = this.dialog.open(CreateRenewalModalComponent, {
      width: '400px',
      data: { subscription }
    });

    dialogRef.beforeClose()
        .subscribe(cycle => {
          if (!cycle) {
            return this.snackbar.error('Could not create renewal');
          }

          subscription.cycles.unshift(cycle);
          this.snackbar.snack('Renewal created successfully.');
        });

  }

  promptBookSubscriptionDelete(sub: Subscription, book: BookSubscription) {
    const dialogRef = this.dialog.open(RemoveBookSubscriptionModalComponent, {
      width: '400px',
      data: {
        subscription: sub,
        bookSubscription: book,
      },
    });
  }

  upsertBookSubscription(subscription: Subscription, bookSubscription?: BookSubscription) {
    const dialogRef = this.dialog.open(EditHardCopyModalComponent, {
      width: '600px',
      data: { subscription, bookSubscription },
    });
  }

}
