import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { NavController } from '@ionic/angular';
import { Router, NavigationExtras } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(private http: HttpClient, public navCtrl: NavController, private router: Router) { }

  getUserDetails(email, password) {
    return this.http.post('http://localhost/Attendance App/myApp/src/app/api/auth.php', {
      email,
      password,
    }).subscribe(data => {
      console.log(Object.values(data));
      const user = Object.values(data);
      const id = user[0];
      if (user[5] == 'intervenant') {
        this.router.navigate(['/home/', id]);
      }
      if (user[5] == 'etudiant') {
        this.router.navigate(['/studentdate/', id]);
      };
    },
      error => {
        console.log(error);
      });
  }

  getCoursList(date, idIntervenant) {
    return this.http.post('http://localhost/Attendance App/myApp/src/app/api/getCours.php?id=' + idIntervenant, {
      date,
    }).subscribe(data => {
      console.log(Object.values(data));
      let planningData = Object.values(data);
      const grabArray = planningData[0];
      const id = grabArray.intervenant_id;
      let navExtras: NavigationExtras = {
        state: {
          planning: planningData
        }
      }
      this.router.navigate(['/cours/', id], navExtras);
      if (planningData.length == 27) {
        alert("Aucune leçon prévue pour cette date")
      }
    },
      error => {
        console.log(error);
      });
  }

  getStudentList(idTeacher, date, time, cours, classe, id_planning) {
    return this.http.post('http://localhost/Attendance App/myApp/src/app/api/getStudentNames.php?id=' + idTeacher, {
      date,
      time,
      cours,
      classe,
      id_planning
    }).subscribe(data => {
      console.log(Object.values(data));
      let studentData = Object.values(data);
      let navExtras: NavigationExtras = {
        state: {
          students: studentData
        }
      }
      this.router.navigate(['/list-students/', idTeacher], navExtras);
    },
      error => {
        console.log(error);
      });
  }

  updateAttendanceDb(id_student, name, date, time, cours, id) {
    return this.http.post('http://localhost/Attendance App/myApp/src/app/api/updateAttendanceDb.php?id=' + id, {
      id_student,
      name,
      date,
      time,
      cours,
      id
    }).subscribe(data => {
      let navExtras: NavigationExtras = {
      }
      this.router.navigate(['/list-students/', id], navExtras);
    },
      error => {
        console.log(error);
      });
  }

  updateAttendanceDb2(id_student, name, date, time, cours, id) {
    return this.http.post('http://localhost/Attendance App/myApp/src/app/api/updateAttendanceDb2.php?id=' + id, {
      id_student,
      name,
      date,
      time,
      cours,
      id
    }).subscribe(data => {
      console.log(data);
      let navExtras: NavigationExtras = {
      }
      this.router.navigate(['/list-students/', id], navExtras);
    },
      error => {
        console.log(error);
      });
  }

  updateAbsenceDb(date, time, cours, lieux, id, etudiant_nom, etudiant_id) {
    return this.http.post('http://localhost/Attendance App/myApp/src/app/api/updateAbsenceDb.php?id=' + id, {
      lieux,
      date,
      time,
      cours,
      id,
      etudiant_nom,
      etudiant_id
    }).subscribe(data => {
      console.log(Object.values(data));
      let info = Object.values(data);
      const array = info[0];
      if (array !== undefined) {
        let navExtras: NavigationExtras = {
        }
      };
    },
      error => {
        console.log(error);
      });
  }

  getStudentCours(date, idStudent) {
    return this.http.post('http://localhost/Attendance App/myApp/src/app/api/getStudentCours.php?id=' + idStudent, {
      date,
    }).subscribe(data => {
      console.log(Object.values(data));
      let planningData = Object.values(data);
      const grabArray = planningData[0];
      const id = grabArray.etudiant;
      if (id !== undefined) {
        let navExtras: NavigationExtras = {
          state: {
            planning: planningData,
          }
        }
        this.router.navigate(['/agenda/', idStudent], navExtras);
      };
      if (planningData.length == 27) {
        alert("Aucune leçon prévue pour cette date")
      }
    },
      error => {
        console.log(error);
      });
  }
}