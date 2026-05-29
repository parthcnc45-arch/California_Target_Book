import { Injectable } from '@angular/core';
import { Resolve, ActivatedRouteSnapshot } from '@angular/router';
import { CTBEvent } from '../../models/ctb-event';
import { EventService } from './event.service';

@Injectable()
export class EventResolver implements Resolve<CTBEvent> {

  constructor(
      private eventService: EventService,
  ) {}

  resolve(route: ActivatedRouteSnapshot) {
    return this.eventService.getByName(route.paramMap.get('event'));
  }
}