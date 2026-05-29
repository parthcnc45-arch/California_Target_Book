import { Component, OnInit, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { MatTableDataSource, MatSort } from '@angular/material';
import { Observable } from 'rxjs/Observable';
import * as Papa from 'papaparse';
import * as moment from 'moment';

import { User } from 'models/user';
import { UserService } from 'app/core/user.service';


@Component({
  selector: 'ctb-users',
  templateUrl: './users.component.html',
  styleUrls: ['./users.component.scss']
})
export class UsersComponent implements OnInit {
  usersData = new MatTableDataSource();
  users$: Observable<Array<User>>;
  isLoading$: Observable<boolean>;
  stats = {
    total: 0,
    active: 0,
    inactive: 0,
  };

  columns = ['status', 'name', 'email', 'company', 'subscribedOn'];
  @ViewChild(MatSort) sort: MatSort;

  constructor(
    public userService: UserService,
    private router: Router,
  ) {
    this.isLoading$ = userService.isLoading$;
  }

  ngOnInit() {
    this.usersData.sort = this.sort;

    this.userService.get()
      .share()
      .subscribe(users => {
        console.log(users);
        this.usersData.data = users;

        this.stats = {
          total: users.length,
          active: users.filter(u => u.hasActiveSubscription).length,
          inactive: users.filter(u => !u.hasActiveSubscription).length,
        };
      });
  }


  viewUser(userId) {
    this.router.navigate(['/contacts', userId]);
  }

  applyFilter(v: string) {
    this.usersData.filter = String(v).trim().toLowerCase();
  }

  exportContacts() {
    const data = this.usersData.data
        .map((u: User) => ({
          Name: u.name,
          Email: u.email,
          Company: u.company,
          'Is Active': u.hasActiveSubscription ? 'Yes' : 'No',
        }));

    const csv = Papa.unparse(data);
    const blob = new Blob([csv]);
    const fn = `ctb_contacts_${moment().format('MM-DD-YYYY')}.csv`;
    if (window.navigator.msSaveOrOpenBlob)  // IE hack; see http://msdn.microsoft.com/en-us/library/ie/hh779016.aspx
      window.navigator.msSaveBlob(blob, fn);
    else {
      const a = window.document.createElement("a");
      a.href = window.URL.createObjectURL(blob, <any>{ type: "text/plain" });
      a.download = fn;
      document.body.appendChild(a);
      a.click();  // IE: "Access is denied"; see: https://connect.microsoft.com/IE/feedback/details/797361/ie-10-treats-blob-url-as-cross-origin-and-denies-access
      document.body.removeChild(a);
    }

  }

}
