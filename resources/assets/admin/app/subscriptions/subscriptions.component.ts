import { Component, OnInit, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { Observable } from 'rxjs/Observable';
import { MatTableDataSource, MatSort } from '@angular/material';

import { Subscription } from 'models/subscription';
import { SubscriptionService } from 'app/core/subscription.service';

@Component({
  selector: 'ctb-subscriptions',
  templateUrl: './subscriptions.component.html',
  styleUrls: ['./subscriptions.component.scss']
})
export class SubscriptionsComponent implements OnInit {
  subsData = new MatTableDataSource();
  isLoading: boolean;
  columns = ['status', 'company', 'contact', 'endDate'];
  @ViewChild(MatSort) sort: MatSort;

  stats = {
    total: 0,
    active: 0,
    inactive: 0,
  };

  constructor(
      private subscriptionService: SubscriptionService,
      private router: Router,
  ) {}

  ngOnInit() {
    this.isLoading = true;
    this.subsData.sort = this.sort;
    this.subsData.filterPredicate = this.filterPredicate;

    this.subscriptionService.index()
        .share()
        .subscribe(subs => {
          this.isLoading = false;
          this.subsData.data = subs;

          this.stats = {
            total: subs.length,
            active: subs.filter(s => s.isActive).length,
            inactive: subs.filter(u => !u.isActive).length,
          };
        });
  }

  viewSubscription(subId: number) {
    this.router.navigate(['subscriptions', subId]);
  }
  viewUser(userId: number) {
    this.router.navigate(['/contacts', userId]);
  }

  filterPredicate(sub: Subscription, filter: string): boolean {
    const s = JSON.stringify(sub).trim().toLowerCase();
    const f = filter.toLowerCase();
    return s.includes(f);
  }

  applyFilter(v: string) {
    this.subsData.filter = String(v).trim().toLowerCase();
  }

}
