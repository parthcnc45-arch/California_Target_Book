import { Component, OnInit, ViewChild, forwardRef } from '@angular/core';
import { ControlValueAccessor, NG_VALUE_ACCESSOR } from '@angular/forms';

import { Observable } from 'rxjs/Observable';
import { Subject } from 'rxjs/Subject';

@Component({
  selector: 'ctb-stripe-input',
  template: `
    <label>Credit or Debit Card</label>
    <div class="el-wrapper"
      [ngClass]="{'valid': token && !err, 'invalid': !!err}">
      <div #cardEl class="element"></div>
    </div>
    <p class="error">{{err}}</p>
  `,
  styles: [`
    :host {
      position: relative;
      display: block;
    }
    label {
      padding: 0;
      position: relative;
      display: block;
      margin: 0 0 20px;
    }
    .el-wrapper {
      padding: 10px;
      border-bottom: 1px solid #9e9e9e;
    }
    :host.valid .el-wrapper {
      border-bottom: 1px solid #4CAF50;
    }
    :host.invalid .el-wrapper {
      border-bottom: 1px solid #F44336;
    }
    .error {
      margin-top: 10px;
      color: #F44336;
    }
  `],
  providers: [
    {
      provide: NG_VALUE_ACCESSOR,
      useExisting: forwardRef(() => StripeInputComponent),
      multi: true
    }
  ]
})
export class StripeInputComponent implements OnInit, ControlValueAccessor {

  stripe: any;
  elements: any;
  card: any;
  err: string;
  @ViewChild('cardEl') cardEl;

  isLoading: boolean;
  _token: string;
  get token() {
    return this._token;
  }
  set token(t: string) {
    this._token = t;
    this.onChange(t);
    this.onTouched();
  }
  onChange: any = () => { };
  onTouched: any = () => { };

  constructor() {
    this.stripe = (<any>window).globals.stripe;
    this.elements = this.stripe.elements();
  }

  ngOnInit() {
    const style = {
      base: {
        fontSize: '16px',
        fontWeight: 200,
        color: '#9a9a9a',
      }
    };

    this.card = this.elements.create('card', { style: style });
    this.card.mount(this.cardEl.nativeElement);

    const changes = new Subject<any>();

    changes
      .do(event => {
        if (event.error) throw event.error
      })
      .filter(event => event.complete)
      .debounceTime(100)
      .do(() => this.isLoading = true)
      .switchMap(() => Observable.fromPromise(
        this.stripe.createToken(this.card)
      ))
      .map(({error, token}) => {
        this.isLoading = false;
        if (error) throw error;
        this.err = null;
        return token;
      })
      .subscribe(
        token => {
          this.token = token.id;
        },
        err => this.err = err.message
      );

    this.card.addEventListener('change', e => changes.next(e));
  }

  writeValue(token: any): void {
    this.token = token;
  }
  registerOnChange(fn: any): void {
    this.onChange = fn;
  }
  registerOnTouched(fn: any): void {
    this.onTouched = fn;
  }
}
