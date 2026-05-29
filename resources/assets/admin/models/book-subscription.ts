import { Doc } from './doc';
import { Address } from './address';
import { Subscription } from './subscription';

export class BookSubscription extends Doc {

  subscription_id: number;
  address: Address;
  subscription: Subscription;

  constructor(body: any) {
    super();
    Object.assign(this, body);
  }
}
