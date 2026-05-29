import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { SharedModule } from 'app/shared/shared.module';
import { UsersComponent } from 'app/users/users.component';

@NgModule({
  imports: [
    SharedModule,
    RouterModule.forChild([
      { path: '', component: UsersComponent },
      { path: 'new', loadChildren: './user-create/user-create.module#UserCreateModule' },
      { path: ':id', loadChildren: './user/user.module#UserModule' },
    ]),
  ],
  declarations: [ UsersComponent]
})
export class UsersModule { }
