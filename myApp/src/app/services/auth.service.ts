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
    return this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/auth.php', {
      email,
      password,
    }).subscribe(data => {
      const user = Object.values(data);
      const id = user[0];
      if (user[5] == 'intervenant') {
        this.router.navigate(['/home/', id]);
      };
      if (user[5] == 'etudiant') {
        return this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/calendarStudent.php', {
          id
        }).subscribe(data => {
          let studentPlanningData = Object.values(data);
          let navExtras: NavigationExtras = {
            state: {
              studentplanning: studentPlanningData
            }
          }
          this.router.navigate(['/studentdate/', id], navExtras);
        });
      }
      error => {
        console.log(error);
      };
    });
  }

  getCalendarDates(id) {
    return this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/calendarTeacher.php', {
      id
    }).subscribe(data => {
      console.log(Object.values(data));
      let planningData = Object.values(data);
      const id = planningData[0].intervenant_id;
      let navExtras: NavigationExtras = {
        state: {
          planning: planningData
        }
      }
      this.router.navigate(['/teacherdate/', id], navExtras);
    });
  }

  getCoursList(date, idIntervenant) {
    return this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/getCours.php?id=' + idIntervenant, {
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

  getStudentList(date, id, id_planning) {
    return this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/getStudentNames.php?id=' + id, {
      date,
      id,
      id_planning,
    }).subscribe(data => {
      // console.log(Object.values(data));
      let studentData = Object.values(data);
      console.log(studentData, "testing");
      const url = window.location.href;
      const id = url.substring(url.lastIndexOf('/') + 1);
      let navExtras: NavigationExtras = {
        state: {
          students: studentData
        }
      }
      this.router.navigate(['/list-students/', id], navExtras);
    },
      error => {
        console.log(error);
      });
  }

  updateAbsenceDb(planning_id, classe, id, etudiant_nom, etudiant_id) {
    return this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/updateAbsenceDb.php?id=' + id, {
      planning_id,
      classe,
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

  getStudentCours(date, id) {
    return this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/getStudentCours.php?id=' + id, {
      date,
    }).subscribe(data => {
      console.log(Object.values(data));
      let planningData = Object.values(data);
      const grabArray = planningData[0];
      const classe = grabArray.classe;
      if (classe !== undefined) {
        let navExtras: NavigationExtras = {
          state: {
            planning: planningData,
          }
        }
        this.router.navigate(['/agenda/', id], navExtras);
      };
      if (planningData.length == 27) {
        alert("Aucune leçon prévue pour cette date")
      }
    },
      error => {
        console.log(error);
      });
  }

  getRdvInfo(id) {
    return this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/getRdvInfo.php?id=' + id, {
      id
    }).subscribe(data => {
      console.log(Object.values(data));
      let classesData = Object.values(data);
      const grabArray = classesData[0][0].classe;
      if (grabArray !== undefined) {
        let navExtras: NavigationExtras = {
          state: {
            classes: classesData,
          }
        }
        this.router.navigate(['/rdv/', id], navExtras);
      };
      if (classesData.length == 0) {
        alert("Aucune data")
      }
    },
      error => {
        console.log(error);
      });
  }
}

