import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators as val, FormArray, AbstractControl } from '@angular/forms';
import { SnackbarService } from 'app/core/snackbar.service';
import { User } from 'models/user';
import { UserService } from '../../../core/user.service';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material';

@Component({
  selector: 'ctb-change-user-password-modal',
  templateUrl: './change-user-password-modal.component.html',
  styleUrls: ['./change-user-password-modal.component.scss']
})
export class ChangeUserPasswordModalComponent implements OnInit {

  passwordForm: FormGroup;
  submitted: boolean;
  formIsLoading: boolean;
  user: User;

  constructor(
      public dialogRef: MatDialogRef<ChangeUserPasswordModalComponent>,
      private fb: FormBuilder,
      private userService: UserService,
      private snackbar: SnackbarService,
      @Inject(MAT_DIALOG_DATA) public data: any,
  ) {
    this.passwordForm = fb.group({
      password: ['', [val.required, val.minLength(6)]],
      password_confirmation: ['', [val.required, val.minLength(6)]],
    })
  }


  ngOnInit() {
    this.user = this.data.user;
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

    this.userService.updatePassword(this.user.id, form.value)
        .subscribe(
            (user: User) => {
              console.log(user);
              this.formIsLoading = false;
              this.snackbar.snack('Subscriber password updated successfully.');
              this.dialogRef.close();
            },
            res => {
              this.formIsLoading = false;
              this.snackbar.error('There are some form errors.');
              this.passwordForm.markAsPristine();
              Object.keys(res.error.errors)
                  .map(k => {
                    this.passwordForm.get(k)
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
      c = this.passwordForm.get(field);
    }
    return c.valid;
  }
  isInvalid(field) {
    let c;
    if (field instanceof AbstractControl) {
      c = field;
    } else {
      c = this.passwordForm.get(field);
    }
    return c.invalid && (c.dirty || c.touched || this.submitted);
  }

  get(field) {
    return this.passwordForm.get(field);
  }

}
