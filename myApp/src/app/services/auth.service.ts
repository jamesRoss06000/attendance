import { Injectable } from '@angular/core';
// Enables us to inject this service into other components
import { HttpClient } from '@angular/common/http';
// Permet d'effectuer des requêtes HTTP
// import { NavController } from '@ionic/angular';
import { Router, NavigationExtras } from '@angular/router';
// 'Router' est un NgModule qui offre des fonctions de navigation 
// et de manipulation d'URL. 'NavigationExtras' donne des options
//  qui modifient la stratégie de navigation, je l'utilise pour 
// passer les données à la page suivante dans un objet.
@Injectable({
  providedIn: 'root'
})
export class AuthService {
  constructor(private http: HttpClient, private router: Router) { }
  // Nous ajoutons'http' et'router' dans le constructeur qui demande'
  // que ces services soient injectés dans le composant.

  getUserDetails(email, password) {
    // On 'POST' les données transmises ('email' et 'password') vers un fichier PHP API et 'Return' le résultat.
    return this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/auth.php', {
      email,
      password,
    }).subscribe(data => {
      // Subscribe' agit comme une fonction asynchrone, ce qui nous permet d'utiliser les données renvoyées par 
      // l'API et d'agir en conséquence. On assigne les données à des variables afin de pouvoir manipuler 
      // l'expérience de l'utilisateur, en utilisant une déclaration 'if'. En fonction du type d'identifiant
      //  de l'utilisateur, il sera envoyé sur une page spécifique, ainsi que les données que nous avons 
      // récupérées de la base de données en utilisant l'API (requête SQL dans le code PHP que nous verrons plus tard).
      const user = Object.values(data);
      const id = user[0];
      // Ci-dessous on voit que la sixième valeur du tableau (user[5]) est soit 'intervenant', soit 'etudiant'.
      if (user[5] == 'intervenant') {
        this.router.navigate(['/home/', id]); // Envoyer à la page de menu avec l'id d'utilisateur, aucune API nécessaire.
      };
      if (user[5] == 'etudiant') {
        return this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/calendarStudent.php', {
          id // Parce que l'étudiant est envoyé directement à son agenda, il faut maintenant extraire les données 
          // nécessaires de la base de données et les envoyer au moment où l'utilisateur est redirigé vers la page 
          // d'agenda, afin que l'agenda puisse être rempli avec les données pertinentes sur la page de chargement.
        }).subscribe(data => {
          // Ici, ces données sont stockées dans la variable 'studentPlanningData', qui est ensuite placée dans 'navExtras' 
          // comme objet qui est ensuite passé dans la ligne de navigation (voir ci-dessous).
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
        console.log(error); // Erreurs enregistrées ici pendant la phase de test.
      };
    });
  }

  getCalendarDates(id) {
    return this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/calendarTeacher.php', {
      id
    }).subscribe(data => {
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

  // OLD CODE BELOW FOR OLD PAGE? NOT USED ANYMORE
  // getStudentCours(date, id) {
  //   return this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/getStudentCours.php?id=' + id, {
  //     date,
  //   }).subscribe(data => {
  //     console.log(Object.values(data));
  //     let planningData = Object.values(data);
  //     const grabArray = planningData[0];
  //     const classe = grabArray.classe;
  //     if (classe !== undefined) {
  //       let navExtras: NavigationExtras = {
  //         state: {
  //           planning: planningData,
  //         }
  //       }
  //       this.router.navigate(['/agenda/', id], navExtras);
  //     };
  //     if (planningData.length == 27) {
  //       alert("Aucune leçon prévue pour cette date")
  //     }
  //   },
  //     error => {
  //       console.log(error);
  //     });
  // }

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

