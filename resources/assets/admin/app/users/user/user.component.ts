import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators as val } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { Observable } from 'rxjs/Observable';
import { User } from 'models/user';
import { UserService } from 'app/core/user.service';
import { CycleService } from 'app/core/cycle.service';
import { SnackbarService } from 'app/core/snackbar.service';
import { ChangeUserPasswordModalComponent } from './change-user-password-modal/change-user-password-modal.component';
import { MatDialog } from '@angular/material';
import { UpdateUserDetailsModalComponent } from './update-user-details-modal/update-user-details-modal.component';

@Component({
  selector: 'ctb-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.scss']
})
export class UserComponent implements OnInit {

  userId: string;
  user$: Observable<User>;
  user: User;

  constructor(
    private userService: UserService,
    private route: ActivatedRoute,
    private router: Router,
    private cycleService: CycleService,
    private snackbar: SnackbarService,
    private fb: FormBuilder,
    private dialog: MatDialog,
  ) {
    this.router.onSameUrlNavigation = 'reload';
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
  }

  ngOnInit() {
    this.route.params.subscribe(params => {
      this.userId = params.id;

      this.user$ = this.userService.getById(params.id)
        .do(u => {
          this.user = u;
        })
        .share();

    });
  }

  editUser() {
    const dialogRef = this.dialog.open(UpdateUserDetailsModalComponent, {
      width: '600px',
      data: { user: this.user },
    });
  }

  changePassword() {
    const dialogRef = this.dialog.open(ChangeUserPasswordModalComponent, {
      height: '370px',
      width: '400px',
      data: { user: this.user },
    });

  }

}
