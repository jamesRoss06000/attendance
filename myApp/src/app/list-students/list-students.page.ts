import { Component, OnInit } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-list-students',
  templateUrl: './list-students.page.html',
  styleUrls: ['./list-students.page.scss'],
})

export class ListStudentsPage implements OnInit {
  planning: any;
  students: any;
  platform: any;
  authState$: Observable<boolean>;

  constructor(private Auth: AuthService, public http: HttpClient, private router: Router, private route: ActivatedRoute) {
    this.route.queryParams.subscribe(params => {
      if (this.router.getCurrentNavigation().extras.state) {
        this.students = this.router.getCurrentNavigation().extras.state.students;
      }
      console.log("students", this.students);
    });
  }

  onChange(event, i) {
    if (event.target.checked) {
      this.students[i].value = true;
    }
    else {
      this.students[i].value = false;
    }
  }

  signalAbsence(event, students) {
    event.preventDefault();
    for (let i = 0; i < students.length; i++) {
      if (!students[i].value || students[i].value == "undefined") {
        students[i].value = false;
        const date = students[i][1];
        const cours = students[i][0];
        const classe = students[i].classe;
        const etudiant_nom = students[i].nom;
        const etudiant_id = students[i].id;
        const url = window.location.href;
        const id = url.substring(url.lastIndexOf('/') + 1);
        this.Auth.updateAbsenceDb(date, cours, classe, id, etudiant_nom, etudiant_id);
        this.router.navigate(['cours/', id]);
      }
      // console.log(students[i].nom, students[i].date, students[i].cours, students[i].lieux, students[i].id);
      // console.log(students[i].id + " => " + students[i].value);
    }
    alert("Mis à jour effectué");
  }

  backPage(event) {
    event.preventDefault();
    const date = this.students[0].date;
    const url = window.location.href;
    const id_intervenant = url.substring(url.lastIndexOf('/') + 1);
    this.router.navigate(['/cours/', id_intervenant]);
    this.Auth.getCoursList(date, id_intervenant);

    console.log(this.students);
  }

  logout() {
    this.router.navigate(['/login/']);
  }

  ngOnInit() {
  }
}
