import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, Validators as val, FormGroup } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material';
import { SnackbarService } from '../../../core/snackbar.service';
import { Company } from 'models/company';
import { AddressFormComponent } from 'app/shared/address-form/address-form.component';
import { CompanyService } from 'app/core/company.service';
import { BookSubscription } from '../../../../models/book-subscription';
import { SubscriptionService } from '../../../core/subscription.service';
import { Subscription } from '../../../../models/subscription';

@Component({
  selector: 'ctb-edit-hard-copy-modal',
  templateUrl: './edit-hard-copy-modal.component.html',
  styleUrls: ['./edit-hard-copy-modal.component.scss']
})
export class EditHardCopyModalComponent implements OnInit {

  bookForm: FormGroup;
  isLoading: boolean;
  get isNew() {
    return !this.data.bookSubscription
  }

  constructor(
    fb: FormBuilder,
    @Inject(MAT_DIALOG_DATA) public data: { subscription: Subscription, bookSubscription?: BookSubscription },
    private snackbar: SnackbarService,
    private subService: SubscriptionService,
    private dialogRef: MatDialogRef<EditHardCopyModalComponent>,
  ) {
    this.bookForm = fb.group({
      address: AddressFormComponent.createForm(data.bookSubscription ? data.bookSubscription.address : null),
    });
  }

  ngOnInit() {
  }

  onSubmit(form: FormGroup) {
    if (form.invalid) return;
    this.isLoading = true;

    const { subscription, bookSubscription } = this.data;

    let action;
    if (this.isNew) {
      action = this.subService.createHardCopySubscription(subscription.id, form.value);
    } else {
      action  = this.subService.editHardCopySubscription(subscription.id, bookSubscription.id, form.value);
    }

    action.subscribe(
        (bookSub) => {
          this.isLoading = false;
          this.snackbar.snack(`Hard Copy subscription ${this.isNew ? 'created' : 'updated'}`);
          this.dialogRef.close(bookSub);
        },
        err => {
          this.isLoading = false;
          console.log(err);
          this.snackbar.error(`Could not ${this.isNew ? 'create' : 'update'} hard copy subscription`);
        },
      );

  }

}
