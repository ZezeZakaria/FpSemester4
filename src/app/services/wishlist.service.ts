import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class WishlistService {
  private wishlist = [];
  private wishlistItemCount = new BehaviorSubject(0);

  constructor() { }

  getWishlist() {
    return this.wishlist;
  }

  getWishlistItemCount() {
    return this.wishlistItemCount.asObservable();
  }

  addProduct(product) {
    let added = false;
    for (let p of this.wishlist) {
      if (p.id === product.id) {
        added = true;
        break;
      }
    }
    if (!added) {
      this.wishlist.push(product);
      this.wishlistItemCount.next(this.wishlistItemCount.value + 1);
    }
  }

  removeProduct(product) {
    for (let [index, p] of this.wishlist.entries()) {
      if (p.id === product.id) {
        this.wishlist.splice(index, 1);
        this.wishlistItemCount.next(this.wishlistItemCount.value - 1);
        break;
      }
    }
  }
}