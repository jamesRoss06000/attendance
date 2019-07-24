import { Component } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-studentdate',
  templateUrl: './studentdate.page.html',
  styleUrls: ['./studentdate.page.scss'],
})
export class StudentdatePage {

  authState$: Observable<boolean>;

  constructor(private Auth: AuthService, public http: HttpClient, private router: Router, private route: ActivatedRoute) { }

  ngOnInit() {
  }

  enterDate(event) {
    event.preventDefault();
    const target = event.target;
    const date = target.querySelector('#date').value;
    const url = window.location.href;
    const id = url.substring(url.lastIndexOf('/') + 1);
    console.log(id);
    this.Auth.getStudentCours(date, id);
  }

  logout() {
    this.router.navigate(['/login/']);
  }
}
