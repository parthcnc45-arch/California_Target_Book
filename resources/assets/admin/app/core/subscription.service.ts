import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import * as moment from 'moment';

import { Subscription } from 'models/subscription';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { BookSubscription } from '../../models/book-subscription';
import { Cycle } from '../../models/cycle';
import { Address } from '../../models/address';

@Injectable()
export class SubscriptionService {

  endpoint = '/api/subscriptions';
  _subscriptions$ = new BehaviorSubject<Array<Subscription>>([]);
  subscriptions$ = this._subscriptions$.asObservable();


  constructor(
      private http: HttpClient,
  ) { }

  private updateWith(subs: Array<Subscription>) {
    const currentSubs = this._subscriptions$.getValue();

    subs.forEach(sub => {
      const i = currentSubs.findIndex(s => s.id === sub.id);
      if (i === -1) {
        currentSubs.push(sub);
      } else {
        Object.assign(currentSubs[i], sub);
      }
    });

    this._subscriptions$.next(currentSubs);
  }

  private subscriptionFor(subId: number) {
    return this.subscriptions$
        .map(subs => subs.find(s => s.id === +subId))
        .filter(s => !!s);
  }

  index() {
    const req = this.http.get<Array<Subscription>>(this.endpoint);
    req.subscribe(subs => this.updateWith(subs));
    return req
        .share()
        .switchMap(() => this._subscriptions$);
    // return this._subscriptions$;
  }

  get(id: number) {
    const req = this.http.get<Subscription>(`${this.endpoint}/${id}`);
    req.subscribe(sub => this.updateWith([sub]));
    return this.subscriptionFor(id);
  }

  /**
   * Create Addon for subscription
   * @param {number} subId - subscription id
   * @param body - body of addon
   */
  createAddon(subId: number, body: any) {
    return this.http.post<Subscription>(`${this.endpoint}/${subId}/addons`, body)
        .do(sub => this.updateWith([sub]));
  }

  createCycle(subId: number, body: any) {
    return this.http.post<Cycle>(`${this.endpoint}/${subId}/cycles`, body)
        .map((cycle: any) => {
          if (typeof cycle.ends_on === 'object') { // fix date formatting from server
            cycle.ends_on = moment(cycle.ends_on.date).format('YYYY-MM-DD');
          }
          return cycle as Cycle;
        })
  }

  indexHardCopies() {
    return this.http.get<Array<BookSubscription>>(`${this.endpoint}/hard-copies`)
  }

  removeAddon(subId: number, addonId: number) {
    return this.http.delete<Subscription>(`${this.endpoint}/${subId}/addons/${addonId}`)
        .do(sub => this.updateWith([sub]));
  }

  createHardCopySubscription(subId: number, data: { address: Address }) {
    return this.http.post<BookSubscription>(`${this.endpoint}/${subId}/hard-copies`, data)
        .do((bs) => {
          const currentSubs = this._subscriptions$.getValue();
          const sub = currentSubs.find((s) => s.id === subId);
          if (!sub) return;
          sub.bookSubscriptions = [...sub.bookSubscriptions, bs];
          this.updateWith([sub]);
        });
  }

  editHardCopySubscription(subId: number, bookSubId: number, data: { address: Address }) {
    return this.http.put<BookSubscription>(`${this.endpoint}/${subId}/hard-copies/${bookSubId}`, data)
        .do((updatedBook) => {
          const currentSubs = this._subscriptions$.getValue();
          const sub = currentSubs.find((s) => s.id === subId);
          if (!sub) return;
          const i = sub.bookSubscriptions.findIndex((b) => b.id === bookSubId);
          sub.bookSubscriptions.splice(i, 1, new BookSubscription({ ...sub.bookSubscriptions[i], ...updatedBook }));
          this.updateWith([sub]);
        })
  }

  removeHardCopySubscription(subId: number, bookSubId: number) {
    return this.http.delete<BookSubscription>(`${this.endpoint}/${subId}/hard-copies/${bookSubId}`)
        .do(() => {
          const currentSubs = this._subscriptions$.getValue();
          const sub = currentSubs.find((s) => s.id === subId);
          if (!sub) return;
          const i = sub.bookSubscriptions.findIndex((b) => b.id === bookSubId);
          sub.bookSubscriptions.splice(i, 1);
          this.updateWith([sub]);
        })
  }

}
