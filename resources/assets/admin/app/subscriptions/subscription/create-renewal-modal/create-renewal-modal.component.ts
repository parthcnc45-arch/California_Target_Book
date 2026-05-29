import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators as val } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material';
import { Subscription } from '../../../../models/subscription';
import { CycleService } from '../../../core/cycle.service';
import { SubscriptionService } from '../../../core/subscription.service';
import * as moment from 'moment';

@Component({
  selector: 'ctb-create-renewal-modal',
  templateUrl: './create-renewal-modal.component.html',
  styleUrls: ['./create-renewal-modal.component.scss']
})
export class CreateRenewalModalComponent implements OnInit {

  renewalForm: FormGroup;
  isLoading: boolean;

  constructor(
      private fb: FormBuilder,
      private subscriptionService: SubscriptionService,
      private dialogRef: MatDialogRef<CreateRenewalModalComponent>,
      @Inject(MAT_DIALOG_DATA) private data: { subscription: Subscription },
  ) {
    const cycle = data.subscription.cycle;

    this.renewalForm = this.fb.group({
      length: [data.subscription.frequency, val.required],
      startDate: [cycle ? cycle.ends_on : new Date(), val.required],
    });
  }

  ngOnInit() {
  }

  onSubmit(form: FormGroup) {
    if (form.invalid) return false;
    this.isLoading = true;

    this.subscriptionService.createCycle(this.data.subscription.id, {
      starts_on: moment(form.value.startDate).format('YYYY-MM-DD'),
      length: form.value.length,
    })
        .do(() => this.isLoading = false)
        .subscribe(
            cycle => this.dialogRef.close(cycle),
            err => {
              console.error(err);
              this.dialogRef.close(false);
            }
        )

  }

}
