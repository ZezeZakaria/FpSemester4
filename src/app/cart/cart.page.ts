import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CartService } from '../services/cart.service';
import { Cart } from '../models/cart.model';
import { Product } from '../models/product.model';
import { environment } from '../../environments/environment';
import { Dialog } from '@capacitor/dialog';

@Component({
  selector: 'app-cart',
  templateUrl: './cart.page.html',
  styleUrls: ['./cart.page.scss'],
})
export class CartPage implements OnInit {
  carts: Cart[] = [];
  cartItemCount: number = 0;

  constructor(private cartService: CartService, private router: Router) {}

  ngOnInit() {
    this.cartService.getCart().subscribe({
      next: (res: any) => {
        this.carts = res.data.map((res) => {
          return {
            ...res,
            product: {
              ...res.product,
              photo: `${environment.storageUrl}/${res.product.photo}`,
            },
          };
        });
        this.cartItemCount = this.carts.length;
      },
    });
  }

  async onRemoveItem(index: number) {
    const productId = this.carts[index].product_id;
    const prevItem = { ...this.carts[index] };
    this.carts.splice(index, 1);
    this.cartService.removeCart(productId).subscribe({
      next: async (res: any) => {
        await Dialog.alert({ message: 'Berhasil menghapus data' });
      },
      error: () => {
        this.carts.splice(index, 0, prevItem);
      },
    });
  }

  goToCheckout() {
    this.router.navigate(['/checkout']);
  }
}
