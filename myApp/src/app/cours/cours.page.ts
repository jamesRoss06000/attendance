import { Component, OnInit } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-cours',
  templateUrl: './cours.page.html',
  styleUrls: ['./cours.page.scss'],
})

export class CoursPage implements OnInit {
  planning: any;
  authState$: Observable<boolean>;
  constructor(private Auth: AuthService, public http: HttpClient, private router: Router, private route: ActivatedRoute) {
    this.route.queryParams.subscribe(params => {
      if (this.router.getCurrentNavigation().extras.state) {
        this.planning = this.router.getCurrentNavigation().extras.state.planning;
        console.log(this.planning);
      }
    });
  }

  // showClasses(event, i) {
  //   event.preventDefault();
  //   const idTeacher = this.planning[i].intervenant_id;
  //   let date = this.planning[i].date;
  //   const time = this.planning[i].debut_am;
  //   const cours = this.planning[i].cours;
  //   const classe = this.planning[i].classe;
  //   const id_planning = this.planning[i].id_planning;
  //   this.Auth.getStudentList(idTeacher, date, time, cours, classe, id_planning);
  // }

  ngOnInit() {
  }

  backPage(event) {
    event.preventDefault();
    const url = window.location.href;
    const id = url.substring(url.lastIndexOf('/') + 1);
    this.router.navigate(['/teacherdate/', id]);
    // console.log(this.planning[0].etudiant);
  }

  logout() {
    this.router.navigate(['/login/']);
  }
}