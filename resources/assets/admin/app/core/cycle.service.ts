import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { Cycle } from 'models/cycle';

@Injectable()
export class CycleService {

  endpoint = '/api/cycles/';
  private isLoadingSource = new BehaviorSubject<boolean>(false);
  public isLoading$ = this.isLoadingSource.asObservable();

  constructor(
    private http: HttpClient,
  ) { }

  getById(id: string) {
    return this.http.get<Cycle>(this.endpoint + id)
      .map(c => new Cycle(c));
  }

  markPaid(id: number) {
    return this.http.put<Cycle>(this.endpoint + id + '/markPaid', {})
      .map(c => new Cycle(c));
  }

  update(id: number, body: any) {
    return this.http.put<Cycle>(this.endpoint + id, body)
        .map(c => new Cycle(c));
  }


}
