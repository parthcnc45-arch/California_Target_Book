import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'stripeCost'
})
export class StripeCostPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    return Number(value) / 100;
  }

}
