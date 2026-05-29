import { NgModule } from '@angular/core';
import { SharedModule } from 'app/shared/shared.module';
import { RouterModule } from "@angular/router";
import { EventsComponent } from './events.component';
import { EventComponent } from './event/event.component';
import { EventService } from './event.service';
import { EventResolver } from './event.resolver';
import { EventCheckinComponent } from './event-checkin/event-checkin.component';

@NgModule({
  imports: [
    SharedModule,
    RouterModule.forChild([
      { path: '', component: EventsComponent },
      {
        path: ':event',
        component: EventComponent,
        resolve: { event: EventResolver },
      },
      {
        path: ':event/check-in',
        resolve: { event: EventResolver },
        component: EventCheckinComponent,
      }
    ])
  ],
  declarations: [
    EventsComponent,
    EventComponent,
    EventCheckinComponent,
  ],
  providers: [
    EventService,
    EventResolver,
  ],
})
export class EventsModule {
}
