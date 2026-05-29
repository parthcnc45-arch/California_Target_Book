import { Component, Inject, OnInit } from '@angular/core';
import { CycleService } from '../../../core/cycle.service';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material';
import { Cycle } from '../../../../models/cycle';
import { SnackbarService } from '../../../core/snackbar.service';

@Component({
  selector: 'ctb-mark-cycle-paid',
  template: `
      <h3 mat-dialog-title>Mark Paid</h3>

      <mat-dialog-content>
        <p>
          Continue to mark this subscription cycle as paid.
        </p>
      </mat-dialog-content>
      
      <mat-dialog-actions>
        <button class="btn btn-default left" mat-dialog-close>Cancel</button>
        <ctb-loader class="right" classes="small" *ngIf="isLoading"></ctb-loader>
        <button class="btn waves-effect waves-light right" (click)="markPaid()">Continue</button>
      </mat-dialog-actions>

  `,
  styles: []
})
export class MarkCyclePaidComponent implements OnInit {

  isLoading: boolean;

  constructor(
      private dialogRef: MatDialogRef<MarkCyclePaidComponent>,
      private cycleService: CycleService,
      private snackbar: SnackbarService,
      @Inject(MAT_DIALOG_DATA) private data: { cycle: Cycle },
  ) { }

  ngOnInit() {
  }

  markPaid() {
    this.isLoading = true;
    this.cycleService.markPaid(this.data.cycle.id)
        .do(() => this.isLoading = false)
        .subscribe(
            cycle => {
              this.snackbar.snack('Subscription cycle was marked as paid.');
              this.dialogRef.close(cycle);
            },
            err => this.snackbar.error('Something went wrong.'),
        );

  }

}
