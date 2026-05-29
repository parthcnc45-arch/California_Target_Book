import { NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';

import { SharedModule } from 'app/shared/shared.module';
import { UserCreateComponent } from './user-create.component';

@NgModule({
  imports: [
    SharedModule,
    ReactiveFormsModule,
    RouterModule.forChild([{ path: '', component: UserCreateComponent }])
  ],
  declarations: [UserCreateComponent]
})
export class UserCreateModule { }
