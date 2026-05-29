
import { Doc } from './doc';
import { EventTicket } from './event-ticket';

export class CTBEvent extends Doc {
    name: string;
    time: string;
    slug: string;
    ticketPrice: number;
    ticketsBought: number;
    tickets: Array<EventTicket>;
}
