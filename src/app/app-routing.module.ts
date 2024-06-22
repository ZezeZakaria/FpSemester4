import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  { path: '', redirectTo: 'welcome', pathMatch: 'full' },
  { path: 'welcome', loadChildren: () => import('./welcome/welcome.module').then(m => m.WelcomePageModule) },
  { path: 'login', loadChildren: () => import('./login/login.module').then(m => m.LoginPageModule) },
  { path: 'signup', loadChildren: () => import('./signup/signup.module').then(m => m.SignupPageModule) },
  { path: 'home/dashboard', loadChildren: () => import('./home/dashboard/dashboard.module').then(m => m.DashboardPageModule) },
  { path: 'cart', loadChildren: () => import('./cart/cart.module').then(m => m.CartPageModule) },
  { path: 'checkout', loadChildren: () => import('./checkout/checkout.module').then(m => m.CheckoutPageModule) },
  { path: 'detail-produk/:id', loadChildren: () => import('./detail-produk/detail-produk.module').then(m => m.DetailProdukPageModule) },
  { path: 'wishlist', loadChildren: () => import('./home/wishlist/wishlist.module').then(m => m.WishlistPageModule) },
  { path: 'history', loadChildren: () => import('./home/history/history.module').then(m => m.HistoryPageModule) },
  { path: 'profile', loadChildren: () => import('./home/profile/profile.module').then(m => m.ProfilePageModule) },
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }