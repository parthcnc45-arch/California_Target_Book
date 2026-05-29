import { Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';

@Injectable()
export class TokenInterceptor implements HttpInterceptor {

  token: string;

  constructor() {
    this.token = document.querySelector('meta[name=ctb_api_token]')
      .getAttribute('content');
  }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    request = request.clone({
      setParams: { 'api_token': this.token }
    });
    return next.handle(request);
  }

}