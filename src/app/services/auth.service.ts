import { environment } from '../../environments/environment';
import { User } from '../models/user.model';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  token: string;
  user?: User;
  headers: HttpHeaders;

  constructor(private http: HttpClient) {
    this.token = localStorage.getItem('token');
    this.user = this.token ? JSON.parse(localStorage.getItem('user')) : null;
  }

  setUser(user?: User) {
    this.user = user;
    localStorage.setItem('user', JSON.stringify(user));
  }

  setToken(token: string) {
    this.token = token.replace('""', '');
    localStorage.setItem('token', JSON.stringify(token));
  }

  login(user: User) {
    return this.http.post(`${environment.baseUrl}/login`, user);
  }

  register(user: User) {
    return this.http.post(`${environment.baseUrl}/register`, user);
  }

  logout() {
    return this.http.post(`${environment.baseUrl}/logout`, {});
  }

  fetchMe() {
    return this.http.get(`${environment.baseUrl}/user`);
  }

  updateProfile(payload: any) {
    return this.http.put(`${environment.baseUrl}/user`, {
      ...payload,
    });
  }

  isLoggedIn() {
    const token = localStorage.getItem('expenseAppToken');
    return !!token;
  }
}
