import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { IonicModule } from '@ionic/angular';
import { RouterModule } from '@angular/router';

import { CartPage } from './cart.page';
import { CartItemComponent } from './cart-item/cart-item.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    RouterModule.forChild([
      {
        path: '',
        component: CartPage,
      },
    ]),
    CartItemComponent,
  ],
  declarations: [CartPage],
})
export class CartPageModule {}
