import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Observable } from 'rxjs/Observable';
import * as moment from 'moment';
import * as Papa from 'papaparse';

import { Poll, PollQuestion } from 'models/poll';
import { PollService } from '../poll.service';
import { MatDialog } from '@angular/material';
import { EditPollDialogComponent } from '../edit-poll-dialog/edit-poll-dialog.component';
import { EditPollQuestionDialogComponent } from '../edit-poll-question-dialog/edit-poll-question-dialog.component';


@Component({
  selector: 'ctb-poll',
  templateUrl: './poll.component.html',
  styleUrls: ['./poll.component.scss']
})
export class PollComponent implements OnInit {

  pollId: string;
  poll$: Observable<Poll>;
  users$: Observable<any>;
  users: Array<any>; // cache users$
  respondents$: Observable<any>;

  questionChartOptions = {
    responsive: true,
    maintainAspectRatio: true,
  };

  constructor(
      private pollService: PollService,
      private route: ActivatedRoute,
      private dialog: MatDialog,
      private router: Router,
  ) {
    this.pollId = this.route.snapshot.paramMap.get('id');
    this.router.onSameUrlNavigation = 'reload';
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
  }

  ngOnInit() {
    this.poll$ = this.pollService.show(this.pollId)
        .share();

    this.users$ = this.pollService.getResponseData(this.pollId)
        .do(users => this.users = users)
        .share();
    this.respondents$ = this.users$
        .map(users => users.filter(u => u.takenPoll));
  }

  editPoll(poll) {
    const dialogRef = this.dialog.open(EditPollDialogComponent, {
      width: '440px',
      data: { poll },
    });

    dialogRef.beforeClose()
        .filter(poll => !!poll)
        .subscribe(poll => this.router.navigate(['/polls', poll.id]));
  }

  exportRespondents() {
    const data = this.users
        .sort((a, b) => moment(a.responseDate).isBefore(b.responseDate) ? -1 : 1)
        .map(u => ({
          'Subscriber': `${u.first_name} ${u.last_name}`,
          'Email': u.email,
          'Company': u.company && u.company.name,
          'Has Responded': u.takenPoll ? 'Yes' : 'No',
          'Responded On': u.takenPoll ? moment(u.responseDate).format('MMM Do, YYYY hh:mm a') : '',
        }));

    const csv = Papa.unparse(data);
    const blob = new Blob([csv]);
    if (window.navigator.msSaveOrOpenBlob)  // IE hack; see http://msdn.microsoft.com/en-us/library/ie/hh779016.aspx
      window.navigator.msSaveBlob(blob, `poll_${this.pollId}_response_data.csv`);
    else {
      const a = window.document.createElement("a");
      a.href = window.URL.createObjectURL(blob, <any>{ type: "text/plain" });
      a.download = `poll_${this.pollId}_response_data.csv`;
      document.body.appendChild(a);
      a.click();  // IE: "Access is denied"; see: https://connect.microsoft.com/IE/feedback/details/797361/ie-10-treats-blob-url-as-cross-origin-and-denies-access
      document.body.removeChild(a);
    }
  }

  editQuestion(question?: PollQuestion) {
    const dialogRef = this.dialog.open(EditPollQuestionDialogComponent, {
      width: '600px',
      data: { pollId: this.pollId, question }
    });

    dialogRef.beforeClose()
        .filter(q => !!q)
        .subscribe(q => this.router.navigate(['/polls', this.pollId]));
  }
}
