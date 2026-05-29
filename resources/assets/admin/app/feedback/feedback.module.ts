import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';

import { SharedModule } from 'app/shared/shared.module';
import { FeedbackComponent } from './feedback.component';
import { FeedbackService } from 'app/feedback/feedback.service';

@NgModule({
  imports: [
    SharedModule,
    RouterModule.forChild([{ path: '', component: FeedbackComponent }])
  ],
  declarations: [FeedbackComponent],
  providers: [FeedbackService]
})
export class FeedbackModule { }
