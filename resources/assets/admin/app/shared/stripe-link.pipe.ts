import { Pipe, PipeTransform } from '@angular/core';
import { environment } from '../../environments/environment';

@Pipe({
  name: 'stripeLink'
})
export class StripeLinkPipe implements PipeTransform {

  base = 'https://dashboard.stripe.com/';

  constructor() {
    if (!environment.production) this.base += 'test/';
  }

  transform(value: any, args?: any): any {
    if (!value) return this.base;

    const abrv = value.split('_')[0];
    let prefix = '';
    switch (abrv) {
      case 'cus':
        prefix = 'customers/';
        break;
      case 'in':
        prefix = 'invoices/';
        break;
    }

    return this.base + prefix + value;
  }

}
