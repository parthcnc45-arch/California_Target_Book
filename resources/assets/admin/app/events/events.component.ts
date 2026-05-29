import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Observable } from 'rxjs/Observable';
import { EventService } from './event.service';
import { CTBEvent } from 'models/ctb-event';

@Component({
  selector: 'ctb-events',
  templateUrl: './events.component.html',
  styleUrls: ['./events.component.scss']
})
export class EventsComponent implements OnInit {
    events$: Observable<Array<CTBEvent>>;
    isLoading$: Observable<boolean>;

  constructor(
      private eventService: EventService,
      private router: Router,
  ) {
    this.isLoading$ = eventService.isLoading$;
  }

  ngOnInit() {
      this.events$ = this.eventService.get();
  }

  viewEvent(e: string) {
      this.router.navigate(['/events', e]);
  }

}
