import { Product } from './product.model';

export interface Cart {
  product: Product;
  product_id: number;
  quantity: number;
}
