import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Product } from '../models/product.model';
import { ProductService } from '../services/product.service';
import { environment } from '../../environments/environment';

@Component({
  selector: 'app-detail-produk',
  templateUrl: './detail-produk.page.html',
  styleUrls: ['./detail-produk.page.scss'],
})
export class DetailProdukPage implements OnInit {
  product?: Product;
  loading: boolean = false;

  constructor(
    private route: ActivatedRoute,
    private productService: ProductService
  ) {}

  ngOnInit() {
    const productId = +this.route.snapshot.paramMap.get('id');
    this.loading = true;

    this.productService.getProduct(productId).subscribe({
      next: (res: any) => {
        this.product = {
          ...res.data,
          photo: `${environment.storageUrl}/${res.data.photo}`,
        };
        this.loading = false;
      },
    });
  }
}
