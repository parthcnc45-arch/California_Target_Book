import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { StripeLinkPipe } from './stripe-link.pipe';
import { DatePipe } from './date.pipe';
import { StripeInputComponent } from './stripe-input.component';
import { LoaderComponent } from './loader.component';

import {
  MatTableModule,
  MatCardModule,
  MatSortModule,
  MatProgressBarModule,
  MatFormFieldModule,
  MatButtonModule,
  MatCheckboxModule, MatDatepickerModule, MatExpansionModule, MatIconModule, MatInputModule, MatMenuModule,
  MatNativeDateModule, MatTooltipModule,
  MatListModule,
  MatSelectModule,
  MatDialogModule,
} from '@angular/material';

import { StripeCostPipe } from './stripe-cost.pipe';
import { AddressFormComponent } from './address-form/address-form.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    RouterModule,
    ReactiveFormsModule,

    MatFormFieldModule,
    MatInputModule,
    MatSelectModule,
  ],
  declarations: [
    StripeLinkPipe,
    DatePipe,
    StripeInputComponent,
    LoaderComponent,
    StripeCostPipe,
    AddressFormComponent,
  ],
  exports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    RouterModule,

    MatTableModule,
    MatSortModule,
    MatCardModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelectModule,
    MatDialogModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatCheckboxModule,
    MatExpansionModule,
    MatIconModule,
    MatTooltipModule,
    MatListModule,
    MatMenuModule,
    MatProgressBarModule,
    MatButtonModule,

    StripeLinkPipe,
    DatePipe,
    StripeInputComponent,
    LoaderComponent,
    StripeCostPipe,
    AddressFormComponent,
  ]
})
export class SharedModule {
}
