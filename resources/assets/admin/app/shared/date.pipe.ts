import { Pipe, PipeTransform } from '@angular/core';
import * as moment from 'moment';

@Pipe({
  name: 'date'
})
export class DatePipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (!value) return '';
    return moment(value).format('MMM Do, YYYY');
  }

}
