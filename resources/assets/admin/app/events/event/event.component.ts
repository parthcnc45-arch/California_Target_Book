import { Component, OnInit, ViewChild } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { MatTableDataSource, MatSort } from '@angular/material';

import * as Papa from 'papaparse';

import { CTBEvent } from 'models/ctb-event';
import { EventTicket } from 'models/event-ticket';
import { SnackbarService } from 'app/core/snackbar.service';
import { EventService } from '../event.service';

@Component({
  selector: 'ctb-event',
  templateUrl: './event.component.html',
  styleUrls: ['./event.component.scss']
})
export class EventComponent implements OnInit {

  event: CTBEvent;
  eventData = new MatTableDataSource();
  stats = {
    total: 0,
    paid: 0,
    unpaid: 0,
  };

  columns = ['is_paid_for', 'holders_name', 'buyerName', 'buyerCompany', 'invoice_id', 'created_at'];
  @ViewChild(MatSort) sort: MatSort;

  constructor(
      private route: ActivatedRoute,
      private snackbar: SnackbarService,
      private eventService: EventService,
  ) { }

  ngOnInit() {
    this.event = this.route.snapshot.data['event'];
    console.log(this.event);

    this.eventData.sort = this.sort;

    this.eventData.data = this.event.tickets;

    this.stats = {
      total: this.event.tickets.length,
      paid: this.event.tickets.filter(u => u.is_paid_for).length,
      unpaid: this.event.tickets.filter(u => !u.is_paid_for).length,
    };
  }

  applyFilter(v: string) {
    this.eventData.filter = String(v).trim().toLowerCase();
  }

  export() {
    const data = this.event.tickets
        .sort((a,b) => {
          const c1 = String(a.buyerCompany).toUpperCase();
          const c2 = String(b.buyerCompany).toUpperCase();
          return (c1 > c2) ? 1 : -1;
        })
        .map(t => ({
          Holder: t.holders_name,
          Company: t.buyerCompany,
          'Is Paid Up': t.is_paid_for ? 'Yes' : 'No',
          'Is Subscriber': t.buyer.has_active_subscription ? 'Yes' : 'No',
          'Stripe Invoice': t.invoice_id,
        }));

    const csv = Papa.unparse(data);
    const blob = new Blob([csv]);
    if (window.navigator.msSaveOrOpenBlob)  // IE hack; see http://msdn.microsoft.com/en-us/library/ie/hh779016.aspx
      window.navigator.msSaveBlob(blob, "filename.csv");
    else {
      const a = window.document.createElement("a");
      a.href = window.URL.createObjectURL(blob, <any>{ type: "text/plain" });
      a.download = `${this.event.slug}_attendees.csv`;
      document.body.appendChild(a);
      a.click();  // IE: "Access is denied"; see: https://connect.microsoft.com/IE/feedback/details/797361/ie-10-treats-blob-url-as-cross-origin-and-denies-access
      document.body.removeChild(a);
    }
  }

  onPaymentChange(ticket: EventTicket) {
    this.eventService.updateTicket(this.event.id, ticket.id, { is_paid_for: ticket.is_paid_for })
        .subscribe(
            t => {
              Object.assign(ticket, t);
              this.snackbar.snack(`Marked the ${ticket.holders_name} ticket as ${t.is_paid_for ? 'paid' : 'unpaid'}.`);
            },
            err => {
              console.error(err);
              this.snackbar.error(`Could not update the ${ticket.holders_name} ticket.`);
            }
        )
  }

}
