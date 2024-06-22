import { Injectable } from '@angular/core';
import { LoadingController, ToastController, AlertController } from '@ionic/angular';

@Injectable({
  providedIn: 'root'
})
export class Helper {
  loading: any;

  constructor(
    private loadingController: LoadingController,
    private toastController: ToastController,
    private alertController: AlertController
  ) { }

  async showLoading(message: string = 'Please wait...') {
    this.loading = await this.loadingController.create({
      message,
    });
    await this.loading.present();
  }

  async dismissLoading() {
    if (this.loading) {
      await this.loading.dismiss();
    }
  }

  async toastNotif(message: string, duration: number = 2000) {
    const toast = await this.toastController.create({
      message,
      duration,
    });
    toast.present();
  }

  async alertNotif(message: string) {
    const alert = await this.alertController.create({
      header: 'Notification',
      message,
      buttons: ['OK'],
    });
    await alert.present();
  }
}