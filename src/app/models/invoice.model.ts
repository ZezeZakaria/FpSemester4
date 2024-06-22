import { Product } from './product.model';

export interface InvoiceDetail {
  id: number;
  product_id: number;
  product: Product;
  quantity: number;
  price: number;
  status: string;
}

export interface Invoice {
  id: number;
  invoice_number: string;
  created_at: string;
  details: InvoiceDetail[];
}
