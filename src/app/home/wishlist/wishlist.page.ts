import { Component, OnInit } from '@angular/core';
import { WishlistService } from '../../services/wishlist.service';

@Component({
  selector: 'app-wishlist',
  templateUrl: './wishlist.page.html',
  styleUrls: ['./wishlist.page.scss'],
})
export class WishlistPage implements OnInit {
  wishlist = [];

  constructor(private wishlistService: WishlistService) { }

  ngOnInit() {
    this.wishlist = this.wishlistService.getWishlist();
  }

  removeWishlistItem(product) {
    this.wishlistService.removeProduct(product);
    this.wishlist = this.wishlistService.getWishlist(); // Update wishlist after removal
  }
}