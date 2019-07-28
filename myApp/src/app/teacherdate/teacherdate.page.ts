import { Component } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-teacherdate',
  templateUrl: 'teacherdate.page.html',
  styleUrls: ['teacherdate.page.scss'],
})
export class TeacherdatePage {

  authState$: Observable<boolean>;

  constructor(private Auth: AuthService, public http: HttpClient, private router: Router, private route: ActivatedRoute) { }

  backPage(event) {
    event.preventDefault();
    const url = window.location.href;
    const id = url.substring(url.lastIndexOf('/') + 1);
    this.router.navigate(['/home/', id]);
    // console.log(this.students);
  }

  enterDate(event) {
    event.preventDefault();
    const target = event.target;
    const date = target.querySelector('#date').value;
    const url = window.location.href;
    const id = url.substring(url.lastIndexOf('/') + 1);
    console.log(id);
    this.Auth.getCoursList(date, id);
  }

  logout() {
    this.router.navigate(['/login/']);
  }
}