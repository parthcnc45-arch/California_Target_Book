import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, Validators as val, FormGroup } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material';
import { SnackbarService } from '../../../core/snackbar.service';
import { Company } from 'models/company';
import { AddressFormComponent } from 'app/shared/address-form/address-form.component';
import { CompanyService } from 'app/core/company.service';

@Component({
  selector: 'ctb-edit-company-modal',
  templateUrl: './edit-company-modal.component.html',
  styleUrls: ['./edit-company-modal.component.scss']
})
export class EditCompanyModalComponent implements OnInit {

  companyForm: FormGroup;
  isLoading: boolean;

  constructor(
    fb: FormBuilder,
    @Inject(MAT_DIALOG_DATA) private data: { company: Company },
    private snackbar: SnackbarService,
    private companyService: CompanyService,
    private dialogRef: MatDialogRef<EditCompanyModalComponent>,
  ) {
    this.companyForm = fb.group({
      name: [data.company.name, [val.required]],
      address: AddressFormComponent.createForm(data.company.address),
    });
  }

  ngOnInit() {
  }

  onSubmit(form: FormGroup) {
    if (form.invalid) return;
    this.isLoading = true;

    console.log(this.data.company, form.value)

    this.companyService.update(this.data.company.id, form.value)
      .subscribe(
        company => {
          this.isLoading = false;
          this.snackbar.snack('Organization updated');
          this.dialogRef.close(company);
        },
        err => {
          this.isLoading = false;
          console.log(err);
          this.snackbar.error('Could not update Organization');
        },
      );

  }

}
