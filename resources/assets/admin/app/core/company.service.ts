import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Company } from 'models/company';


@Injectable()
export class CompanyService {

  endpoint = '/api/companies/';

  constructor(
    private http: HttpClient,
  ) { }

  update(id: number, body: any) {
    return this.http.put<Company>(this.endpoint + id, body);
  }

}
