import { Component, OnInit, ViewChild, ChangeDetectorRef } from '@angular/core';
import { FormBuilder, FormGroup, Validators as val, FormArray, AbstractControl } from '@angular/forms';
import { Router } from '@angular/router';

import { lang } from 'moment';
import { UserService } from 'app/core/user.service';
import { User } from 'models/user';
import { SnackbarService } from 'app/core/snackbar.service';

@Component({
  selector: 'ctb-user-create',
  templateUrl: './user-create.component.html',
  styleUrls: ['./user-create.component.scss']
})
export class UserCreateComponent implements OnInit {

  subscriberForm: FormGroup;
  submitted: boolean;
  formIsLoading: boolean;

  pricing = {
    base: { '12': 1200, '24': 2200 },
  };

  totals = {
    base: 0,
    addons: 0,
    books: 0,
    total: 0,
  };

  get book_addresses(): FormArray {
    return this.subscriberForm.get('book_addresses') as FormArray;
  }

  get addons(): FormArray {
    return this.subscriberForm.get('addons') as FormArray;
  }

  constructor(
    private cdr: ChangeDetectorRef,
    private fb: FormBuilder,
    private userService: UserService,
    private router: Router,
    private snackbar: SnackbarService,
  ) {
    this.subscriberForm = this.fb.group({
      first_name: ['', val.required],
      last_name: ['', val.required],
      email: ['', [val.required, val.email]],
      company: this.fb.group({
          name: [''],
          address: this.fb.group({
            line1: [''],
            line2: [''],
            city: [''],
            state: [''],
            zip_code: [''],
          })
      }),
      phone_number: [''],

      subscription_length: ['24', val.required],
      book_count: [0, val.min(0)],
      book_addresses: this.fb.array([]),
      addon_count: [0, val.min(0)],
      addons: this.fb.array([]),

      subscription_cost: [2200, [val.required, val.min(0)]],
      book_cost: [
        100 * (<any>window).globals.getBookCountForSubscription(2),
        [ val.required, val.min(0) ],
      ],
      addon_cost: [100, [ val.required, val.min(0)] ],

      payment_method: ['stripe', val.required],
      stripe_token: [],
      is_paid_for: [false],
      send_invoice: [true],
    });

    /**
     * Watch
     */
    this.subscriberForm.get('subscription_length').valueChanges
      .forEach(freq => {
        this.subscriberForm.patchValue({
          subscription_cost: this.pricing.base[freq],
          book_cost: 100 * (<any>window).globals.getBookCountForSubscription(+freq / 12),
          addon_cost: 100,
        });
      });

    this.subscriberForm.get('stripe_token').valueChanges
      .distinctUntilChanged()
      .forEach(tok => {
        this.subscriberForm.get('stripe_token').updateValueAndValidity();
        this.cdr.detectChanges();
      });

    this.subscriberForm.get('payment_method').valueChanges
      .forEach(method => {
        const t = this.subscriberForm.get('stripe_token');
        t.clearValidators();
        t.reset();
        t.setValidators(method === 'stripe' ? val.required : []);
        t.updateValueAndValidity();
      });

    this.subscriberForm.get('book_count').valueChanges
      .forEach(count => {
        const addresses = this.subscriberForm.get('book_addresses') as FormArray;
        const cur = addresses.value;

        if (cur.length < count) {
          const add = Array(count - cur.length)
            .fill(this.fb.group({
              line1: ['', val.required],
              line2: [''],
              city: ['', val.required],
              state: ['', val.required],
              zip_code: ['', val.required],
              special_instructions: [''],
            }))
            .forEach(fg => addresses.push(fg));

        } else {
          Array(cur.length - count).fill(0)
            .map((_, i) => cur.length - i - 1)
            .forEach(i => addresses.removeAt(i));
        }

      });

    this.subscriberForm.get('addon_count').valueChanges
      .forEach(count => {
        const addons = this.subscriberForm.get('addons') as FormArray;
        const cur = addons.value;

        if (cur.length < count) {
          const add = Array(count - cur.length)
            .fill(this.fb.control('', [val.required, val.email]))
            .forEach(fg => addons.push(fg));

        } else {
          Array(cur.length - count).fill(0)
            .map((_, i) => cur.length - i - 1)
            .forEach(i => addons.removeAt(i));
        }

      });

      this.subscriberForm.valueChanges
        .forEach(f => {
          // update totals
          const totals = {
            base: f.subscription_cost,
            addons: f.addon_count * f.addon_cost,
            books: f.book_count * f.book_cost,
            total: 0,
          };
          totals.total = totals.base + totals.addons + totals.books;
          this.totals = totals;

          // Erase server errors,
          // Need to remove the server error after input
          //  so that the form will be seen as valid
          (function checkServerErrors(controls) {
            controls.forEach(c => {
                if (c instanceof FormArray) {
                  return checkServerErrors(c.controls);
                }
                if (c.hasError('server') && c.dirty) {
                  const e = c.errors;
                  delete c.errors.server;
                  c.setErrors(e);
                }
              });
          })(
            Object.keys(this.subscriberForm.controls)
              .map(k => this.subscriberForm.controls[k])
          );

        });
  }

  ngOnInit() {
  }

  onSubmit(form) {
    this.submitted = true;
    if (form.invalid) return false;
    this.formIsLoading = true;

    const body = form.value;
    const stripeMultiplier = 100;

    body.subscription_cost *= stripeMultiplier;
    body.book_cost *= stripeMultiplier;
    body.addon_cost *= stripeMultiplier;

    this.userService.create(body)
      .subscribe(
        (user: User) => {
          console.log(user);
          this.formIsLoading = false;
          this.snackbar.snack('Subscriber created successfully');
          this.router.navigate(['/contacts', user.id]);
        },
        res => {
          this.formIsLoading = false;
          this.snackbar.error('There are some form errors.');
          this.subscriberForm.markAsPristine();
          Object.keys(res.error.errors)
            .map(k => {
              this.subscriberForm.get(k)
                .setErrors({ server: res.error.errors[k] });
            });
        }
      );
  }

  isValid(field) {
    let c;
    if (field instanceof AbstractControl) {
      c = field;
    } else {
      c = this.subscriberForm.get(field);
    }
    return c.valid;
  }
  isInvalid(field) {
    let c;
    if (field instanceof AbstractControl) {
      c = field;
    } else {
      c = this.subscriberForm.get(field);
    }
    return c.invalid && (c.dirty || c.touched || this.submitted);
  }

  get(field) {
    return this.subscriberForm.get(field);
  }

  decrement(field) {
    const c = this.subscriberForm.get(field);
    c.setValue(+c.value <= 0 ? 0 : +c.value - 1);
  }
  increment(field) {
    const c = this.subscriberForm.get(field);
    c.setValue(+c.value + 1);
  }

}
