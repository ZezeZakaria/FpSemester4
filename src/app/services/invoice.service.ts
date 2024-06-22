import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root',
})
export class InvoiceService {
  constructor(private http: HttpClient) {}

  getAll() {
    return this.http.get(`${environment.baseUrl}/invoice`);
  }

  get(id: number) {
    return this.http.get(`${environment.baseUrl}/invoice/${id}`);
  }

  create(payload: any) {
    return this.http.post(`${environment.baseUrl}/invoice`, payload);
  }

  uploadPayment(id: number, payload: any) {
    return this.http.post(
      `${environment.baseUrl}/invoice/${id}/payment`,
      payload
    );
  }
}
