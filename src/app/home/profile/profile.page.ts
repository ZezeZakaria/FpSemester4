import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { AlertController, LoadingController } from '@ionic/angular';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { User } from '../../models/user.model';
import { Dialog } from '@capacitor/dialog';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.page.html',
  styleUrls: ['./profile.page.scss'],
})
export class ProfilePage implements OnInit {
  form: FormGroup = new FormGroup({
    name: new FormControl<string>('', [Validators.required]),
    email: new FormControl<string>('', [Validators.required, Validators.email]),
  });

  constructor(
    private router: Router,
    private authService: AuthService,
    private loadingCtrl: LoadingController,
    private alertCtrl: AlertController
  ) {}

  ngOnInit(): void {
    const user: User = this.authService.user;
    this.form.controls.name.setValue(user.name);
    this.form.controls.email.setValue(user.email);
  }

  async updateProfile() {
    const loading = await this.loadingCtrl.create({
      message: 'Please wait',
    });

    await loading.present();

    this.authService.updateProfile(this.form.value).subscribe({
      next: async (response: any) => {
        loading.dismiss();

        this.authService.setUser(response.data);
        await Dialog.alert({ message: 'Berhasil mengubah data' });
      },
      error: (error) => {
        loading.dismiss();
        console.log(error);
      },
    });
  }

  async onLogout() {
    this.alertCtrl
      .create({
        header: 'Logout',
        message: 'Ingin Keluar?',
        buttons: [
          { text: 'Stay' },
          {
            text: 'Leave',
            handler: () => {
              this.authService.logout().subscribe({
                next: () => {
                  localStorage.removeItem('expenseAppToken');
                  this.authService.setToken('');
                  this.authService.setUser(null);
                  this.router.navigateByUrl('/login');
                },
                error: (error) => {
                  console.log(error);
                },
              });
            },
          },
        ],
      })
      .then((alert) => alert.present());
  }
}
