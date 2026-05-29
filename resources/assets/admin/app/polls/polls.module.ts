import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { ChartsModule } from 'ng2-charts';

import { SharedModule } from 'app/shared/shared.module';
import { PollsComponent } from './polls.component';
import { PollComponent } from './poll/poll.component';
import { PollService } from './poll.service';
import { QuestionDataPipe } from './poll/question-data.pipe';
import { EditPollDialogComponent } from './edit-poll-dialog/edit-poll-dialog.component';
import { EditPollQuestionDialogComponent } from './edit-poll-question-dialog/edit-poll-question-dialog.component';

@NgModule({
  imports: [
    SharedModule,
    ChartsModule,
    RouterModule.forChild([
      { path: '', component: PollsComponent },
      { path: ':id', component: PollComponent },
    ])
  ],
  declarations: [PollsComponent, PollComponent, QuestionDataPipe, EditPollDialogComponent, EditPollQuestionDialogComponent],
  providers: [PollService],
  entryComponents: [EditPollDialogComponent, EditPollQuestionDialogComponent],
})
export class PollsModule { }
