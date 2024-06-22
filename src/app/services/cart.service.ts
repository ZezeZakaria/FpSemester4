import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment';
import { AuthService } from './auth.service';

@Injectable({
  providedIn: 'root',
})
export class CartService {
  constructor(private http: HttpClient) {}

  getCart() {
    return this.http.get(`${environment.baseUrl}/user/cart`, {});
  }

  addCartQty(productId: number) {
    return this.http.post(
      `${environment.baseUrl}/user/cart/${productId}/increase`,
      {}
    );
  }

  deductCartQty(productId: number) {
    return this.http.post(
      `${environment.baseUrl}/user/cart/${productId}/decrease`,
      {}
    );
  }

  removeCart(productId: number) {
    return this.http.delete(
      `${environment.baseUrl}/user/cart/${productId}/remove`,
      {}
    );
  }
}
