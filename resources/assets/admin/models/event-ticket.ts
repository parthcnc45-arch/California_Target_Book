import * as moment from 'moment';

import { Doc } from './doc';
import { User } from './user';

export class EventTicket extends Doc {
  buyer_id: number;
  buyer: User;
  event: string;
  holders_name: string;
  invoice_id: string;
  is_paid_for: boolean;
  checked_in_at: Date;
  created_at: Date;

  get buyerName() {
    return this.buyer.name;
  }
  get buyerCompany() {
    return this.buyer.company;
  }

  constructor(body) {
    super();
    Object.assign(this, body);
    if (!this.buyer) this.buyer = <User>{};
  }
}
