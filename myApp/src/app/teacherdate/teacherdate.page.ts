import { Component, ViewChild, Inject, LOCALE_ID } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { HttpClient } from '@angular/common/http';
import { ActivatedRoute, Router } from '@angular/router';
import { CalendarComponent } from 'ionic2-calendar/calendar';
import * as moment from 'moment';
import { AlertController } from '@ionic/angular';

@Component({
  selector: 'app-teacherdate',
  templateUrl: 'teacherdate.page.html',
  styleUrls: ['teacherdate.page.scss'],
})
export class TeacherdatePage {
  planning: any;

  constructor(private Auth: AuthService, public http: HttpClient, private router: Router, private route: ActivatedRoute,
     private alertCtrl: AlertController, @Inject(LOCALE_ID) private locale: string) {
    this.route.queryParams.subscribe(params => {
      if (this.router.getCurrentNavigation().extras.state) {
        this.planning = this.router.getCurrentNavigation().extras.state.planning;
        // On extrait les données de l'objet à l'aide de element=>.
        this.planning.forEach(element => {
          let dateEvent = [];
          if (element.debut_am != "") {
            dateEvent.push([element.debut_am, element.fin_am]);
          }
          if (element.debut_pm != "") {
            dateEvent.push([element.debut_pm, element.fin_pm]);
          }
          // ^^ Les heures de début et de fin de chaque ligne (chaque leçon dans la planification) 
          // sont poussées dans le tableau dateEvent.

          // 
          dateEvent.forEach(d => {
          // Les heures de début et de fin sont ajoutées à la date.
            let dateStartEvent = element.date + " " + d[0];
            let dateEndEvent = element.date + " " + d[1];
          // 'eventTmp' est rempli de valeurs d'élément
            let eventTmp = {
              title: element.cours,
              desc: element.lieux + " " + element.adresse,
              startTime: moment(dateStartEvent, "YYYY-MM-DD h:mm").toDate(),
              endTime: moment(dateEndEvent, "YYYY-MM-DD h:mm").toDate(),
              allDay: false,
              id: element.id_planning
            }
          // new event pushed into eventSource array
            this.eventSource.push(eventTmp);
          });

        });
        this.myCal.loadEvents();
      }
    });
  }

  @ViewChild(CalendarComponent) myCal: CalendarComponent;

  minDate = new Date().toISOString();

  eventSource = [];
  viewTitle;

  calendar = {
    mode: 'month',
    currentDate: new Date(),
  }

  // event = {
  //   title: "",
  //   desc: '',
  //   startTime: '',
  //   endTime: "",
  //   allDay: false,
  //   classId: ""
  // };

  ngOnInit() {
    this.resetEvent();
  }

  resetEvent() {
    this.event = {
      title: "",
      desc: '',
      startTime: new Date().toISOString(),
      endTime: new Date().toISOString(),
      allDay: false,
      classId: ""
    };
  }

  // Modifier le mois/semaine/jour en cours
  next() {
    var swiper = document.querySelector('.swiper-container')['swiper'];
    swiper.slideNext();
  }
  back() {
    var swiper = document.querySelector('.swiper-container')['swiper'];
    swiper.slidePrev();
  }

  // Focus aujourd'hui
  today() {
    this.calendar.currentDate = new Date();
  }

  // Changement des dates sélectionnée et donc du titre
  onViewTitleChanged(title) {
    this.viewTitle = title;
  }

  // L'événement du calendrier a été cliqué
  async onEventSelected(event) {
    {
      let date = event.startTime;
      const id_planning = event.id;
      const url = window.location.href;
      const id = url.substring(url.lastIndexOf('/') + 1);
      this.Auth.getStudentList(date, id, id_planning);
    }
  }

  // Même fonction sur chaque page (sauf login). Redirige l'utilisateur vers la 
  // page précédente, avec l'ID ajouté à la fin de l'URL
  backPage(event) {
    event.preventDefault();
    const url = window.location.href;
    const id = url.substring(url.lastIndexOf('/') + 1);
    this.router.navigate(['/home/', id]);
  }
  
  // Même fonction sur chaque page (sauf login).Redirige l'utilisateur vers la 
  // page '/login'.
  logout() {
    this.router.navigate(['/login/']);
  }
}
