import { Component, OnInit } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { HttpClient } from '@angular/common/http';
// import { Observable } from 'rxjs';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

  // authState$: Observable<boolean>;

  constructor(private Auth: AuthService, public http: HttpClient) { }

  ngOnInit() {
  }

  loginUser(event){
    event.preventDefault();
    const target = event.target;
    const email = target.querySelector('#email').value;
    const password = target.querySelector('#password').value;

    this.Auth.getUserDetails(email, password);
    console.log(email, password, "test");
  }
}