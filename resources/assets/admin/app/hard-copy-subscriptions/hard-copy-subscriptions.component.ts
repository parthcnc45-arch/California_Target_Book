import { Component, OnInit, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { Observable } from 'rxjs/Observable';
import { MatTableDataSource, MatSort } from '@angular/material';

import { BookSubscription } from 'models/book-subscription';
import { SubscriptionService } from 'app/core/subscription.service';

@Component({
  selector: 'ctb-hard-copy-subscriptions',
  templateUrl: './hard-copy-subscriptions.component.html',
  styleUrls: ['./hard-copy-subscriptions.component.scss']
})
export class HardCopySubscriptionsComponent implements OnInit {
  booksData = new MatTableDataSource();
  isLoading: boolean;
  columns = ['status', 'company', 'address'];
  @ViewChild(MatSort) sort: MatSort;

  stats = {
    total: 0,
    active: 0,
    inactive: 0,
  };

  constructor(
      private subscriptionService: SubscriptionService,
      private router: Router,
  ) { }

  ngOnInit() {
    this.isLoading = true;
    this.booksData.sort = this.sort;
    this.booksData.filterPredicate = this.filterPredicate;

    this.subscriptionService.indexHardCopies()
        .share()
        .subscribe(subs => {
          this.isLoading = false;
          this.booksData.data = subs;

          const active = subs.filter(book => book.subscription && book.subscription.isActive).length;

          this.stats = {
            total: subs.length,
            active,
            inactive: subs.length - active,
          };
        });
  }


  viewSubscription(subId: number) {
    this.router.navigate(['/subscriptions', subId]);
  }

  filterPredicate(sub: BookSubscription, filter: string): boolean {
    const s = JSON.stringify(sub).trim().toLowerCase();
    const f = filter.toLowerCase();
    return s.includes(f);
  }

  applyFilter(v: string) {
    this.booksData.filter = String(v).trim().toLowerCase();
  }
}
