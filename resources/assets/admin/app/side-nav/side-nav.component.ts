import { Component, OnInit } from '@angular/core';
import { User } from '../../models/user';

@Component({
  selector: 'ctb-side-nav',
  templateUrl: './side-nav.component.html',
  styleUrls: ['./side-nav.component.scss']
})
export class SideNavComponent implements OnInit {

  admin: User = (<any>window).ADMIN_USER;

  views = [
    { path: '/subscriptions', name: 'Subscriptions', icon: 'receipt'},
    { path: '/hard-copy-subscriptions', name: 'Hard Copies', icon: 'book'},
    { path: '/contacts', name: 'Contacts', icon: 'people'},
    { path: '/events', name: 'Events', icon: 'event'},
    { path: '/polls', name: 'Polls', icon: 'assessment'},
    { path: '/feedback', name: 'Feedback', icon: 'thumbs_up_down'},
  ];

  constructor() { }

  ngOnInit() {
  }

}
