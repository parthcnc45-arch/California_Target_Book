import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

const routes: Routes = [
  { path: '', redirectTo: 'subscriptions', pathMatch: 'full' },
  { path: 'contacts', loadChildren: 'app/users/users.module#UsersModule' },
  { path: 'subscriptions', loadChildren: 'app/subscriptions/subscriptions.module#SubscriptionsModule' },
  { path: 'hard-copy-subscriptions', loadChildren: 'app/hard-copy-subscriptions/hard-copy-subscriptions.module#HardCopySubscriptionsModule' },
  { path: 'feedback', loadChildren: 'app/feedback/feedback.module#FeedbackModule' },
  { path: 'events', loadChildren: 'app/events/events.module#EventsModule' },
  { path: 'polls', loadChildren: 'app/polls/polls.module#PollsModule' },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
