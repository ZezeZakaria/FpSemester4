import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { LoadingController } from '@ionic/angular';
import { AuthService } from '../services/auth.service';

@Component({
  // eslint-disable-next-line @angular-eslint/component-selector
  selector: 'signup.page',
  templateUrl: './signup.page.html',
  styleUrls: ['./signup.page.scss'],
})
export class SignupPage implements OnInit {
  form: FormGroup = new FormGroup({});
  errorMessage: string = '';

  constructor(
    private loadingCtrl: LoadingController,
    private authService: AuthService,
    private router: Router
  ) {}

  ngOnInit() {
    this.form = new FormGroup({
      name: new FormControl('', [Validators.required]),
      email: new FormControl('', [Validators.required, Validators.email]),
      password: new FormControl('', [Validators.required]),
      address: new FormControl('', [Validators.required]),
    });
  }

  async onRegister() {
    const loading = await this.loadingCtrl.create({
      message: 'Please wait',
    });

    await loading.present();

    this.authService.register(this.form.value).subscribe({
      next: (res: any) => {
        loading.dismiss();
        this.authService.setToken(res.data.token);
        this.authService.setUser(res.data.user);
        this.router.navigateByUrl('/home/dashboard');
      },
      error: (error) => {
        loading.dismiss();
        this.handleErrorResponse(error);
      },
    });
  }

  private handleErrorResponse(error: any) {
    if (error.status === 422) {
      this.errorMessage = error.error.message;
    } else {
      this.errorMessage = 'An unexpected error occurred. Please try again.';
    }
  }
}
