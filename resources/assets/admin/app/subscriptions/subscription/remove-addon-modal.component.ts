import { Component, Inject, OnInit } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material';

@Component({
  selector: 'ctb-remove-addon-modal',
  template: `
    <h3 mat-dialog-title>Remove Addon</h3>

    <mat-dialog-content>
      <p>
        This will remove the addon <b>{{data.user.first_name}} {{data.user.last_name}}</b>
        from the <b>{{ data.company }}</b>
        Target Book Subscription.
      </p>
    </mat-dialog-content>

    <mat-dialog-actions>

      <button mat-button mat-dialog-close
          class="btn z-depth-0 waves-effect waves-light blue-grey lighten-5 blue-grey-text left" 
          type="submit">
        Cancel
      </button>

      <button [mat-dialog-close]="true" mat-button class="waves-effect waves-danger btn right red darken-4 red-text text-lighten-4">
        Remove
      </button>
    </mat-dialog-actions>
  `,
  styles: [`
      b {
          font-weight: 700;
      }
  `]
})
export class RemoveAddonModalComponent implements OnInit {

  constructor(
      @Inject(MAT_DIALOG_DATA) public data: any,
  ) { }

  ngOnInit() {
  }

}
