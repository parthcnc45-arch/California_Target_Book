import { Component, OnInit, ViewChild } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { MatTableDataSource, MatSort } from '@angular/material';

import { CTBEvent } from 'models/ctb-event';
import { EventTicket } from 'models/event-ticket';
import { SnackbarService } from 'app/core/snackbar.service';
import { EventService } from '../event.service';

@Component({
  selector: 'ctb-event-checkin',
  templateUrl: './event-checkin.component.html',
  styleUrls: ['./event-checkin.component.scss']
})
export class EventCheckinComponent implements OnInit {

  event: CTBEvent;
  eventData = new MatTableDataSource();

  columns = ['checked_in', 'holders_name', 'buyerCompany'];
  @ViewChild(MatSort) sort: MatSort;

  stats: any = {
    checkedIn: 0,
    waiting: 0,
  };

  constructor(
      private route: ActivatedRoute,
      private snackbar: SnackbarService,
      private eventService: EventService,
  ) { }

  ngOnInit() {
    this.event = this.route.snapshot.data['event'];
    this.eventData.sort = this.sort;
    this.eventData.data = this.event.tickets;

    this.updateStats();
  }

  updateStats() {
    const checkedIn = this.event.tickets.filter(t => t.checked_in_at).length;
    this.stats = {
      checkedIn,
      waiting: this.event.tickets.length - checkedIn,
    };
  }

  applyFilter(v: string) {
    this.eventData.filter = String(v).trim().toLowerCase();
  }

  toggleTicket(ticket: EventTicket) {

    const data = { checked_in_at: new Date() };
    if (ticket.checked_in_at) data.checked_in_at = null;

    this.eventService.updateTicket(this.event.id, ticket.id, data)
        .subscribe(
            t => {
              Object.assign(ticket, t);
              this.snackbar.snack(`${ticket.checked_in_at ? 'Marked' : 'Unmarked'} ${ticket.holders_name} as checked in.`);
              this.updateStats();
            },
            err => {
              console.error(err);
              this.snackbar.error(`Could not update the ${ticket.holders_name} ticket.`);
            }
        )
  }

}
