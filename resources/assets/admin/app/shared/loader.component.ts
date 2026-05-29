import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'ctb-loader',
  template: `
  <div [class]="'preloader-wrapper active ' + classes">
    <div class="spinner-layer spinner-red-only">
      <div class="circle-clipper left">
        <div class="circle"></div>
      </div><div class="gap-patch">
        <div class="circle"></div>
      </div><div class="circle-clipper right">
        <div class="circle"></div>
      </div>
    </div>
  </div>
  `,
  styles: []
})
export class LoaderComponent {

  @Input() classes: string;

  constructor() { }

}
