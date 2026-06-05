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
    { path: '/subscriptions', name: 'Subscriptions', icon: 'receipt' },
    { path: '/hard-copy-subscriptions', name: 'Hard Copies', icon: 'book' },
    { path: '/contacts', name: 'Contacts', icon: 'people' },
    { path: '/events', name: 'Events', icon: 'event' },
    { path: '/polls', name: 'Polls', icon: 'assessment' },
    { path: '/feedback', name: 'Feedback', icon: 'thumbs_up_down' },
    { path: '/ghl-subscriptions', name: 'Ghl Subscription List', icon: 'grid_on' },
  ];

  constructor() { }

  ngOnInit() {
  }

  getInitials(): string {
    if (!this.admin) {
      return 'AD';
    }
    if (this.admin.name) {
      const parts = this.admin.name.trim().split(/\s+/);
      if (parts.length >= 2) {
        return (parts[0].charAt(0) + parts[parts.length - 1].charAt(0)).toUpperCase();
      }
      return parts[0].charAt(0).toUpperCase();
    }
    if (this.admin.first_name || this.admin.last_name) {
      const first = this.admin.first_name ? this.admin.first_name.charAt(0) : '';
      const last = this.admin.last_name ? this.admin.last_name.charAt(0) : '';
      return (first + last).toUpperCase() || 'AD';
    }
    return 'AD';
  }

}
