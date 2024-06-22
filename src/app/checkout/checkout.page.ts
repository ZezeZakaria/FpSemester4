import { Component, OnInit } from '@angular/core';
import { CartService } from '../services/cart.service';
import { Cart } from '../models/cart.model';
import { environment } from '../../environments/environment';
import { LoadingController } from '@ionic/angular';
import { InvoiceService } from '../services/invoice.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-checkout',
  templateUrl: './checkout.page.html',
  styleUrls: ['./checkout.page.scss'],
})
export class CheckoutPage implements OnInit {
  cart: Cart[] = [];

  constructor(
    private router: Router,
    private cartService: CartService,
    private loadingCtrl: LoadingController,
    private invoiceService: InvoiceService
  ) {}

  ngOnInit() {
    this.cartService.getCart().subscribe({
      next: (res: any) => {
        this.cart = res.data.map((d) => {
          return {
            ...d,
            product: {
              ...d.product,
              photo: `${environment.storageUrl}/${d.product.photo}`,
            },
          };
        });
      },
    });
  }

  async checkout() {
    const loading = await this.loadingCtrl.create({
      message: 'Please wait',
    });

    await loading.present();

    this.invoiceService
      .create({
        details: this.cart.map((c) => {
          return {
            product_id: c.product_id,
            quantity: c.quantity,
          };
        }),
      })
      .subscribe({
        next: () => {
          loading.dismiss();
          this.router.navigateByUrl('history');
        },
      });
  }

  getTotal() {
    return this.cart.reduce((i, j) => i + j.quantity * j.product?.price, 0);
  }
}
