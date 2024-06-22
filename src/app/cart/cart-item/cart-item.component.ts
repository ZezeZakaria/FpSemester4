import { Component, Input } from '@angular/core';
import { Cart } from '../../models/cart.model';
import { IonicModule } from '@ionic/angular';
import { Product } from '../../models/product.model';
import { CartService } from '../../services/cart.service';

@Component({
  selector: 'app-cart-item',
  templateUrl: './cart-item.component.html',
  styleUrls: ['./cart-item.component.scss'],
  imports: [IonicModule],
  standalone: true,
})
export class CartItemComponent {
  @Input() cart: Cart;
  @Input() index: number;
  @Input() onRemoveItem: (index: number) => void;
  loading: boolean = false;

  constructor(private cartService: CartService) {}

  decreaseCartItem(product: Product) {
    this.loading = true;
    this.cartService.deductCartQty(product.id).subscribe({
      next: () => {
        this.cart.quantity -= 1;
        if (this.cart.quantity <= 0) {
          this.removeCartItem();
        }
        this.loading = false;
      },
    });
  }

  increaseCartItem(product: Product) {
    this.loading = true;
    this.cartService.addCartQty(product.id).subscribe({
      next: () => {
        this.cart.quantity += 1;

        this.loading = false;
      },
    });
  }

  removeCartItem() {
    this.onRemoveItem(this.index);
  }
}
