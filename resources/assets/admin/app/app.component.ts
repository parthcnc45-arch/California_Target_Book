import {Component, OnInit} from '@angular/core';
import {Router, NavigationStart, NavigationEnd} from '@angular/router';

@Component({
    selector: 'ctb-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {

    loading = true;

    constructor(private router: Router) {
    }

    ngOnInit() {
        this.router.events
            .subscribe((e: NavigationStart | NavigationEnd) => {
                this.loading = e instanceof NavigationStart;
            });
    }
}
