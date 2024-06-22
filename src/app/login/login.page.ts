import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { LoadingController } from '@ionic/angular';
import { AuthService } from '../services/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {
  form: FormGroup = new FormGroup({});
  user: any = null;

  constructor(
    private loadingCtrl: LoadingController,
    private authService: AuthService,
    private router: Router
  ) {}

  ngOnInit() {
    this.form = new FormGroup({
      email: new FormControl('', [Validators.required]),
      password: new FormControl('', [Validators.required]),
    });
  }

  async onLogin() {
    const loading = await this.loadingCtrl.create({
      message: 'Please wait',
    });

    await loading.present();

    this.authService.login(this.form.value).subscribe({
      next: (response: any) => {
        loading.dismiss();
        this.form.reset();

        this.authService.setToken(response.token);
        this.authService.setUser(response.user);

        this.router.navigateByUrl('/home/dashboard');
      },
      error: (error) => {
        loading.dismiss();
        console.log(error);
      },
    });
  }
}
