import * as moment from 'moment';
import { Doc } from './doc';

export class User extends Doc {
  name: string;
  first_name: string;
  last_name: string;
  email: string;
  has_password: boolean;
  phone_number: string;
  company: string;
  notes: string;
  role: string;
  verified: boolean;
  stripe_id: string;
  hasActiveSubscription: boolean;
  has_active_subscription: boolean;

  subscriptions: Array<any>;

  subscribedOn: string;

  constructor(body: any) {
    super();
    Object.assign(this, body);

    this.subscribedOn = moment(this.createdAt).format('MMM Do, YYYY');
  }
}
