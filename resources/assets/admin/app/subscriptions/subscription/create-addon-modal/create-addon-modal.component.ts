import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators as val, AbstractControl } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material';

import { SnackbarService } from 'app/core/snackbar.service';
import { SubscriptionService } from '../../../core/subscription.service';
import { Subscription } from '../../../../models/subscription';

@Component({
  selector: 'ctb-create-addon-modal',
  templateUrl: './create-addon-modal.component.html',
  styleUrls: ['./create-addon-modal.component.scss']
})
export class CreateAddonModalComponent implements OnInit {

  addonForm: FormGroup;
  submitted: boolean;
  formIsLoading: boolean;

  constructor(
      public dialogRef: MatDialogRef<CreateAddonModalComponent>,
      private fb: FormBuilder,
      private subService: SubscriptionService,
      private snackbar: SnackbarService,
      @Inject(MAT_DIALOG_DATA) public data: any,
  ) {
    this.addonForm = fb.group({
      email: ['', [val.required, val.email]],
      first_name: [''],
      last_name: [''],
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
    this.submitted = true;
    if (form.invalid) return false;
    this.formIsLoading = true;

    this.subService.createAddon(this.data.subscriptionId, form.value)
        .subscribe(
            (sub: Subscription) => {
              this.formIsLoading = false;
              this.snackbar.snack('Created Add-on Account Successfully.');
              this.dialogRef.close();
            },
            res => {
              this.formIsLoading = false;
              this.snackbar.error('There are some form errors.');
              this.addonForm.markAsPristine();
              Object.keys(res.error.errors)
                  .map(k => {
                    this.addonForm.get(k)
                        .setErrors({ server: res.error.errors[k] });
                  });
            }
        );
  }

  isValid(field) {
    let c;
    if (field instanceof AbstractControl) {
      c = field;
    } else {
      c = this.addonForm.get(field);
    }
    return c.valid;
  }
  isInvalid(field) {
    let c;
    if (field instanceof AbstractControl) {
      c = field;
    } else {
      c = this.addonForm.get(field);
    }
    return c.invalid && (c.dirty || c.touched || this.submitted);
  }

  get(field) {
    return this.addonForm.get(field);
  }

}
