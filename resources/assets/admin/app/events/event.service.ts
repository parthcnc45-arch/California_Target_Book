import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { CTBEvent } from 'models/ctb-event';
import { EventTicket } from '../../models/event-ticket';

@Injectable()
export class EventService {

    endpoint = '/api/events';
    private isLoadingSource = new BehaviorSubject<boolean>(false);
    public isLoading$ = this.isLoadingSource.asObservable();

    constructor(
        private http: HttpClient
    ) { }

    get() {
        this.isLoadingSource.next(true);
        return this.http.get<Array<CTBEvent>>(this.endpoint)
            .do(() => this.isLoadingSource.next(false));
    }

    getByName(slug: string) {
        return this.http.get<CTBEvent>(`${this.endpoint}/${slug}`)
            .map(event => {
                event.tickets = event.tickets.map(t => new EventTicket(t));
                return event;
            });
    }

    updateTicket(eventId: number, ticketId: number, body: any) {
        return this.http.put<EventTicket>(`${this.endpoint}/${eventId}/tickets/${ticketId}`, body);
    }

    export(eventId: number) {

    }

}
