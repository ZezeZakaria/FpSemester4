import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { RouteReuseStrategy } from '@angular/router';
import { IonicModule, IonicRouteStrategy } from '@ionic/angular';
import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';
import { HTTP_INTERCEPTORS, HttpClientModule } from '@angular/common/http';
import { CartService } from './services/cart.service';
import { WishlistService } from './services/wishlist.service';
import { IonicStorageModule } from '@ionic/storage-angular'; // Import IonicStorageModule
import { ReactiveFormsModule } from '@angular/forms';
import { AppInterceptor } from './services/app.interceptor';

@NgModule({
  declarations: [AppComponent],
  imports: [
    BrowserModule,
    IonicModule.forRoot(),
    AppRoutingModule,
    HttpClientModule,
    IonicStorageModule.forRoot(), // Add IonicStorageModule here
    ReactiveFormsModule,
  ],
  providers: [
    { provide: HTTP_INTERCEPTORS, useClass: AppInterceptor, multi: true },
    { provide: RouteReuseStrategy, useClass: IonicRouteStrategy },
    CartService,
    WishlistService,
  ],
  bootstrap: [AppComponent],
})
export class AppModule {}
