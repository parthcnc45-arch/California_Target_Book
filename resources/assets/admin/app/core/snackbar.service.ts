import { Injectable } from '@angular/core';
import Snackbar from 'node-snackbar';

@Injectable()
export class SnackbarService {

  private defaults = {
    pos: 'bottom-right',
    showAction: false,
  };

  constructor() { }

  snack(options: any = {}) {
    // Give option for string arg
    if (typeof options === 'string') {
      options = { text: options };
    }
    Snackbar.show(
      Object.assign({}, this.defaults, options)
    );
  }

  error(options: any = {}) {
    // Give option for string arg
    if (typeof options === 'string') {
      options = { text: options };
    }
    Snackbar.show(
      Object.assign({customClass: 'red darken-3'}, this.defaults, options)
    );
  }

}
