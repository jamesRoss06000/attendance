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

    });
  }


  // buttonOn(event, i) { 
  //   event.preventDefault();
  //   console.log(this.students[i]);
  //   const id_student = this.students[i].id;
  //   const name = this.students[i].etudiant;
  //   const date = this.students[i].date;
  //   const time = this.students[i].time;
  //   const cours = this.students[i].cours;
  //   const url = window.location.href;
  //   const id = url.substring(url.lastIndexOf('/') + 1);
  //   this.Auth.updateAttendanceDb(id_student, name, date, time, cours, id);
  // }

  // buttonOff(event, i) {
  //   event.preventDefault();
  //   console.log(this.students[i]);
  //   const id_student = this.students[i].id;
  //   const name = this.students[i].etudiant;
  //   const date = this.students[i].date;
  //   const time = this.students[i].time;
  //   const cours = this.students[i].cours;
  //   const url = window.location.href;
  //   const id = url.substring(url.lastIndexOf('/') + 1);
  //   this.Auth.updateAttendanceDb2(id_student, name, date, time, cours, id);
  // }

  // confirmAttendance(event, i) {
  //   event.preventDefault();
  //   console.log(this.students[i]);
  //   const id_student = this.students[i].id;
  //   const name = this.students[i].etudiant;
  //   const date = this.students[i].date;
  //   const time = this.students[i].time;
  //   const cours = this.students[i].cours;
  //   const url = window.location.href;
  //   const id = url.substring(url.lastIndexOf('/') + 1);
  //   this.Auth.updateAttendanceDb(id_student, name, date, time, cours, id);
  // }

onChange(event, i) {
    if (event.target.checked) {
      // this.buttonOn(event, i);
      this.students.value = true;
      console.log(this.students.value, i);
    }
    else {
      // this.buttonOff(event, i)
      this.students.value = false;
      console.log(this.students.value, i);
    }
  }

  signalAbsence(event, i) {
    event.preventDefault();
    
    //  loop through students to find which have false value, add to array ??
     {
      const date = this.students[0].date;
      const time = this.students[0].time;
      const cours = this.students[0].cours;
      const lieux = this.students[0].lieux;
      const etudiant_nom = this.students[0].nom;
      const etudiant_id = this.students[0].id;
      // const teacherId = this.students[0].teacherId;
      const url = window.location.href;
      const id = url.substring(url.lastIndexOf('/') + 1);
      this.Auth.updateAbsenceDb(date, time, cours, lieux, id, etudiant_nom, etudiant_id);
      alert("Mis à jour effectué");
      this.router.navigate(['cours/', id]);
    } 
    else {
      const url = window.location.href;
      const id = url.substring(url.lastIndexOf('/') + 1);
      alert("Mis à jour effectué");
      this.router.navigate(['cours/', id]);
    }
  }

  backPage(event) {
    event.preventDefault();
    const id = this.students[0].intervenant_id;
    const date = this.students[0].date;
    const time = this.students[0].time;
    const cours = this.students[0].cours;
    const lieux = this.students[0].lieux;
    const etudiant_nom = this.students[0].nom;
    const etudiant_id = this.students[0].id;
    // const teacherId = this.students[0].teacherId;
    this.router.navigate(['/cours/', id]);
    this.Auth.updateAbsenceDb(date, time, cours, lieux, id, etudiant_nom, etudiant_id);
    console.log(this.students);
  }

  logout() {
    this.router.navigate(['/login/']);
  }

  ngOnInit() {
  }
}
