import { Component, Inject, OnInit } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material';
import { BookSubscription } from '../../../models/book-subscription';
import { Subscription } from '../../../models/subscription';
import { SubscriptionService } from '../../core/subscription.service';
import { SnackbarService } from '../../core/snackbar.service';

interface RemoveBookSubscriptionModalComponentData {
  subscription: Subscription;
  bookSubscription: BookSubscription;
}

@Component({
  selector: 'ctb-remove-book-subscription-modal',
  template: `
    <h3 mat-dialog-title>Remove Book Subscription</h3>

    <form (submit)="onSubmit()">

      <mat-dialog-content>
        <p>
          Are you sure you want remove this hard copy subscription for <b>{{ company }}</b>?
        </p>
        <p>
          {{ addr.line1 }} <br/>
          {{ addr.line2 }} <br *ngIf="!!addr.line2"/>
          {{ addr.city }}, {{ addr.state }} {{ addr.zip_code }}
        </p>
      </mat-dialog-content>

      <div mat-dialog-actions>
        <button type="button" mat-button mat-dialog-close>Cancel</button>
        <button type="submit" [disabled]="isLoading" color="primary" mat-flat-button>Remove</button>
      </div>

      <mat-progress-bar *ngIf="isLoading" mode="indeterminate"></mat-progress-bar>

    </form>
  `,
  styles: [`
      b {
          font-weight: 700;
      }
  `]
})
export class RemoveBookSubscriptionModalComponent implements OnInit {

  isLoading: boolean;

  get company() {
    return this.data.subscription.company.name
  }

  get addr() {
    return this.data.bookSubscription.address;
  }

  constructor(
      @Inject(MAT_DIALOG_DATA) public data: RemoveBookSubscriptionModalComponentData,
      private subService: SubscriptionService,
      private snackbar: SnackbarService,
      private dialogRef: MatDialogRef<RemoveBookSubscriptionModalComponent>,
  ) { }

  ngOnInit() {
  }

  onSubmit() {
    this.isLoading = true;
    const { subscription, bookSubscription } = this.data;
    this.subService.removeHardCopySubscription(subscription.id, bookSubscription.id)
        .subscribe(
            () => {
              this.isLoading = false;
              this.snackbar.snack('Successfully removed hard copy subscription');
              this.dialogRef.close();
            },
            (err) => {
              console.error(err);
              this.isLoading = false;
              this.snackbar.error('Something went wrong, could not remove book subscription');
            }
        )
  }

}
