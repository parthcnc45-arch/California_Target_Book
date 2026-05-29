import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { ReactiveFormsModule } from '@angular/forms';
import { SharedModule } from 'app/shared/shared.module';
import { UserComponent } from 'app/users/user/user.component';
import { ChangeUserPasswordModalComponent } from './change-user-password-modal/change-user-password-modal.component';
import { UpdateUserDetailsModalComponent } from './update-user-details-modal/update-user-details-modal.component';

@NgModule({
  imports: [
    SharedModule,
    ReactiveFormsModule,
    RouterModule.forChild([{ path: '', component: UserComponent }])
  ],
  declarations: [UserComponent, ChangeUserPasswordModalComponent, UpdateUserDetailsModalComponent],
  entryComponents: [ChangeUserPasswordModalComponent, UpdateUserDetailsModalComponent],
})
export class UserModule { }
