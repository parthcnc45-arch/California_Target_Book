import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { User } from 'models/user';
import { Observable } from 'rxjs/Observable';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';

@Injectable()
export class UserService {

  endpoint = '/api/users';
  private isLoadingSource = new BehaviorSubject<boolean>(false);
  public isLoading$ = this.isLoadingSource.asObservable();

  cache = {};

  constructor(
    private http: HttpClient,
  ) { }

  get(): Observable<Array<User>> {
    this.isLoadingSource.next(true);
    return this.http.get<Array<User>>(this.endpoint)
      .map(users => users.map(u => new User(u)))
      .do(() => this.isLoadingSource.next(false));
  }

  getById(id: string, refresh?: boolean): Observable<User> {
    if (this.cache[id] && !refresh) {
      return Observable.of(this.cache[id]);
    }

    return this.http.get<User>(`${this.endpoint}/${id}`)
      .map(u => new User(u))
      .do(u => this.cache[u.id] = u);
  }

  create(body: any) {
    return this.http.post(this.endpoint, body);
  }

  update(userId: string | number, edits: any) {
    return this.http.put<User>(`${this.endpoint}/${userId}`, edits)
      .do(u => Object.assign(this.cache[u.id], u));
  }

  updatePassword(userId: number, body: {password: string, confirm_password: string}) {
    return this.http.put<User>(`${this.endpoint}/${userId}/password`, body)
        .do(u => Object.assign(this.cache[u.id], u));
  }

}
