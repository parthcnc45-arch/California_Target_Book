import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { Observable } from 'rxjs/Observable';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { Feedback } from 'models/feedback';

@Injectable()
export class FeedbackService {

  endpoint = '/api/feedback';
  private isLoadingSource = new BehaviorSubject<boolean>(false);
  public isLoading$ = this.isLoadingSource.asObservable();

  constructor(
    private http: HttpClient
  ) { }

  get() {
    this.isLoadingSource.next(true);
    return this.http.get<Array<Feedback>>(this.endpoint)
      .do(() => this.isLoadingSource.next(false));
  }

}
