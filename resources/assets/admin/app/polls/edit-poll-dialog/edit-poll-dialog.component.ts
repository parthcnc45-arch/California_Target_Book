import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { FormBuilder, FormGroup, Validators as val } from '@angular/forms';

import * as moment from 'moment';
import { PollService } from '../poll.service';
import { Poll } from '../../../models/poll';

@Component({
  selector: 'ctb-create-poll-dialog',
  templateUrl: './edit-poll-dialog.component.html',
  styleUrls: ['./edit-poll-dialog.component.scss']
})
export class EditPollDialogComponent implements OnInit {

  pollForm: FormGroup;
  isLoading: boolean;

  get pollIsNew() {
    return !this.data || !this.data.poll;
  }

  constructor(
      private pollService: PollService,
      private dialogRef: MatDialogRef<EditPollDialogComponent>,
      private fb: FormBuilder,
      @Inject(MAT_DIALOG_DATA) private data: { poll: Poll },
  ) {
    const p = (data && data.poll) || {
      title: '',
      starts_on: moment().format('YYYY-MM-DD'),
      ends_on: moment().add(7, 'days').format('YYYY-MM-DD'),
    };

    this.pollForm = fb.group({
      title: [p.title, val.required],
      startDate: [p.starts_on, val.required],
      endDate: [p.ends_on, val.required],
    })
  }

  ngOnInit() {
  }

  onSubmit(form: FormGroup) {
    if (form.invalid) return false;

    this.isLoading = true;

    const p = {
      title: form.value.title,
      starts_on: moment(form.value.startDate).format('YYYY-MM-DD'),
      ends_on: moment(form.value.endDate).format('YYYY-MM-DD'),
    };

    let action;
    if (this.pollIsNew) {
      action = this.pollService.create(p)
    } else {
      action = this.pollService.update(this.data.poll.id, p);
    }

    action
        .take(1)
        .do(() => this.isLoading = false)
        .subscribe(
            res => this.dialogRef.close(res),
            err => {
              console.error(err);
            }
        );

  }

}
