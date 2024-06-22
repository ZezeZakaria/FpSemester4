import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CartService } from '../../services/cart.service';
import { WishlistService } from '../../services/wishlist.service';
import { AuthService } from '../../services/auth.service';
import { Product } from '../../models/product.model';
import { ProductService } from '../../services/product.service';
import { environment } from '../../../environments/environment';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.page.html',
  styleUrls: ['./dashboard.page.scss'],
})
export class DashboardPage implements OnInit {
  userName: string = 'User'; // Placeholder untuk userName, ganti sesuai kebutuhan
  products: Product[] = [];

  constructor(
    private cartService: CartService,
    private wishlistService: WishlistService,
    public authService: AuthService,
    private productService: ProductService,
    private router: Router
  ) {
    this.userName = authService.user?.name ?? 'USER';
  }

  ngOnInit() {
    this.productService.getProducts().subscribe({
      next: (res: any) => {
        this.products = res.data.map((d) => {
          return {
            ...d,
            photo: `${environment.storageUrl}/${d.photo}`,
          };
        });
      },
    });
  }

  async addToCart(product: Product) {
    this.cartService.addCartQty(product.id).subscribe({
      next: (res: any) => {
        console.log('test');
      },
    });
  }

  addToWishlist(product) {
    this.wishlistService.addProduct(product);
  }

  goToDetail(product) {
    this.router.navigate(['/detail-produk', product.id]);
  }

  goToCheckout() {
    this.router.navigate(['/checkout']);
  }
}
