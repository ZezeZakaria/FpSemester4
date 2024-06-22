import { Component, OnInit } from '@angular/core';
import { InvoiceService } from '../../services/invoice.service';
import { Invoice } from '../../models/invoice.model';
import { LoadingController } from '@ionic/angular';

@Component({
  selector: 'app-history',
  templateUrl: './history.page.html',
  styleUrls: ['./history.page.scss'],
})
export class HistoryPage implements OnInit {
  invoices: Invoice[] = [];
  files: File[] = [];

  constructor(
    private invoiceService: InvoiceService,
    private loadingCtrl: LoadingController
  ) {}

  ngOnInit() {
    this.fetchInvoice();
  }

  fetchInvoice() {
    this.invoiceService.getAll().subscribe({
      next: (res: any) => {
        this.invoices = res.data.map((d) => {
          return {
            ...d,
            amount: d.details.reduce((a, b) => a + b.quantity * b.price, 0),
          };
        });
      },
    });
  }

  onFileUpload(event: Event, index: number) {
    const input = event.target as HTMLInputElement;

    if (input.files && input.files.length) {
      const file = input.files[0];
      this.files[index] = file;
    }
  }

  async uploadPayment(index: number) {
    const loading = await this.loadingCtrl.create({
      message: 'Loading...',
    });
    await loading.present();
    const formData = new FormData();
    formData.append('image', this.files[index]);

    this.invoiceService
      .uploadPayment(this.invoices[index].id, formData)
      .subscribe({
        next: (res) => {
          loading.dismiss();
          this.fetchInvoice();
        },
      });
  }

  currencyFormat(num: number) {
    return new Intl.NumberFormat().format(num);
  }
}
