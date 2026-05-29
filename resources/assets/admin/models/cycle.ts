import * as moment from 'moment';
import { Doc } from './doc';

export class Cycle extends Doc {
  starts_on: string;
  ends_on: string;
  payment_method: string;
  invoice_id: string;
  subscription_id: string;

  isCurrent: boolean;
  isPending: boolean;

  invoice: any;

  constructor(body: any) {
    super();
    Object.assign(this, body);

    this.isPending = !this.starts_on && !this.ends_on;
    this.isCurrent = moment().isBetween(this.starts_on, this.ends_on);
  }
}
