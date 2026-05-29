import * as moment from 'moment';
import { Doc } from './doc';
import { Cycle } from './cycle';
import { Company } from './company';
import { BookSubscription } from './book-subscription';

export class Subscription extends Doc {

  frequency: number;
  account_id: number;

  cycle: Cycle;
  company: Company;
  cycles: Array<Cycle>;
  inactiveCycles: Array<Cycle>;
  bookSubscriptions: BookSubscription[];
  isActive: boolean;

  constructor(body: any) {
    super();
    Object.assign(this, body);
  }
}
