import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RestApiService {

  constructor(private http: HttpClient) { }

  post(options: { url: string, headers: any, data: any }): Observable<any> {
    const headers = new HttpHeaders(options.headers);
    return this.http.post(options.url, options.data, { headers });
  }
}