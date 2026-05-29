import { Component, Inject, OnInit } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material';
import { User } from '../../../../models/user';
import { FormBuilder, FormGroup, Validators as val } from '@angular/forms';
import { UserService } from '../../../core/user.service';
import { SnackbarService } from '../../../core/snackbar.service';

@Component({
  selector: 'ctb-update-user-details-modal',
  templateUrl: './update-user-details-modal.component.html',
  styleUrls: ['./update-user-details-modal.component.scss']
})
export class UpdateUserDetailsModalComponent implements OnInit {

  userForm: FormGroup;
  isLoading: boolean;

  constructor(
      fb: FormBuilder,
      @Inject(MAT_DIALOG_DATA) private data: { user: User },
      private userService: UserService,
      private snackbar: SnackbarService,
      private dialogRef: MatDialogRef<UpdateUserDetailsModalComponent>,
  ) {
    const u = data.user;
    this.userForm = fb.group({
      first_name: [u.first_name, [val.required]],
      last_name: [u.last_name, [val.required]],
      email: [u.email, [val.required, val.email]],
      phone_number: [u.phone_number],
      notes: [u.notes],
    });
  }

  ngOnInit() {
  }

  onSubmit(form: FormGroup) {
    if (form.invalid) return;
    this.isLoading = true;

    const value = {
      ...form.value,
      phone_number: form.value.phone_number || '',
      notes: form.value.notes || '',
    };

    this.userService.update(this.data.user.id, value)
        .subscribe(
            user => {
              this.isLoading = false;
              this.dialogRef.close();
              this.snackbar.snack('Subscriber updated successfully.');
            },
            res => {
              this.isLoading = false;
              Object.keys(res.error.errors)
                  .forEach((k) => {
                    this.userForm.get(k).setErrors({ server: res.error.errors[k] });
                  });
            }
        );
  }

}
