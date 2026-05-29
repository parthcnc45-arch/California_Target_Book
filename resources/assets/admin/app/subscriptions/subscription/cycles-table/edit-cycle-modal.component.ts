import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators as val } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material';

import moment from 'moment';

import { CycleService } from 'app/core/cycle.service';
import { SnackbarService } from 'app/core/snackbar.service';
import { Cycle } from '../../../../models/cycle';

@Component({
  selector: 'ctb-edi-cycle-modal',
  template: `

    <form [formGroup]="form" (submit)="onSubmit(form)">

      <h3 mat-dialog-title>Change Subscription Expiration</h3>

      <mat-dialog-content>

        <mat-form-field>
          <mat-label>Start Date</mat-label>
          <input formControlName="startDate" matInput [matDatepicker]="startPicker">
          <mat-datepicker-toggle matSuffix [for]="startPicker"></mat-datepicker-toggle>
          <mat-datepicker #startPicker></mat-datepicker>
        </mat-form-field>
        
        <mat-form-field>
          <mat-label>End Date</mat-label>
          <input formControlName="endDate" matInput [matDatepicker]="endPicker">
          <mat-datepicker-toggle matSuffix [for]="endPicker"></mat-datepicker-toggle>
          <mat-datepicker #endPicker></mat-datepicker>
        </mat-form-field>

      </mat-dialog-content>

      <mat-dialog-actions>

        <button mat-button mat-dialog-close
            class="btn btn-default left" (click)="cancel()"
            type="submit">
          Cancel
        </button>

        <ctb-loader class="right" classes="small" *ngIf="formIsLoading"></ctb-loader>
        <button mat-button type="submit" [disabled]="formIsLoading" class="waves-effect waves-light btn right right">
          Save
        </button>
      </mat-dialog-actions>
    </form>
  `,
  styles: [` `],
})
export class EditCycleModalComponent implements OnInit {

  formIsLoading: boolean;
  form: FormGroup;

  constructor(
    public dialogRef: MatDialogRef<EditCycleModalComponent>,
    private fb: FormBuilder,
    private cycleService: CycleService,
    private snackbar: SnackbarService,
    @Inject(MAT_DIALOG_DATA) public data: { cycle: Cycle },
  ) {
    this.form = fb.group({
      startDate: [data.cycle.starts_on, [val.required]],
      endDate: [data.cycle.ends_on, [val.required]],
    });
  }

  ngOnInit() {
  }

  cancel() {
    this.dialogRef.close();
  }

  onNoClick(): void {
    this.cancel();
  }

  onSubmit(form) {
    if (form.invalid) return false;
    this.formIsLoading = true;

    const starts_on = moment(form.value.startDate).format('YYYY-MM-DD');
    const ends_on = moment(form.value.endDate).format('YYYY-MM-DD');

    this.cycleService.update(this.data.cycle.id, { ends_on, starts_on })
        .subscribe(
            cycle => {
              this.formIsLoading = false;
              this.snackbar.snack('Updated Subscription Expiration.');
              this.dialogRef.close({ cycle });
            },
            err => {
              console.error(err);
              this.formIsLoading = false;
              this.snackbar.error('Something went wrong.');
            }
        );
  }

}
