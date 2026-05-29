import { Component, OnInit, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { PollService } from './poll.service';
import { Observable } from 'rxjs/Observable';
import { Poll } from 'models/poll';
import { MatTableDataSource, MatSort, MatDialog } from '@angular/material';
import { EditPollDialogComponent } from './edit-poll-dialog/edit-poll-dialog.component';

@Component({
  selector: 'ctb-polls',
  templateUrl: './polls.component.html',
  styleUrls: ['./polls.component.scss']
})
export class PollsComponent implements OnInit {

  isLoading: boolean;

  pollsData = new MatTableDataSource();
  columns = ['id', 'title', 'response_count', 'starts_on', 'ends_on'];
  @ViewChild(MatSort) sort: MatSort;

  constructor(
      private router: Router,
      private pollService: PollService,
      private dialog: MatDialog,
  ) { }

  ngOnInit() {
    this.pollsData.sort = this.sort;

    this.isLoading = true;

    this.pollService.index()
        .share()
        .do(() => this.isLoading = false)
        .subscribe(polls => this.pollsData.data = polls);
  }

  viewPoll(pollId) {
    this.router.navigate(['/polls', pollId]);
  }

  createPoll() {
    const dialogRef = this.dialog.open(EditPollDialogComponent, {
      width: '440px',
    });

    dialogRef.beforeClose()
        .filter(poll => !!poll)
        .subscribe(poll => this.viewPoll(poll.id));
  }
}
