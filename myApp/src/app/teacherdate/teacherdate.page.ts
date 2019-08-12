import { Component, ViewChild, Inject, LOCALE_ID } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
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
  authState$: Observable<boolean>;

  constructor(private Auth: AuthService, public http: HttpClient, private router: Router, private route: ActivatedRoute, private alertCtrl: AlertController, @Inject(LOCALE_ID) private locale: string) {
    this.route.queryParams.subscribe(params => {
      if (this.router.getCurrentNavigation().extras.state) {
        this.planning = this.router.getCurrentNavigation().extras.state.planning;
        console.log(this.planning);
        this.planning.forEach(element => {
          let dateEvent = [];
          if (element.debut_am != "") {
            dateEvent.push([element.debut_am, element.fin_am]);
          }
          if (element.debut_pm != "") {
            dateEvent.push([element.debut_pm, element.fin_pm]);
          }
          dateEvent.forEach(d => {
            let dateStartEvent = element.date + " " + d[0];
            let dateEndEvent = element.date + " " + d[1];
            let eventTmp = {
              title: element.cours,
              desc: element.lieux + " " + element.adresse,
              startTime: moment(dateStartEvent, "YYYY-MM-DD h:mm").toDate(),
              endTime: moment(dateEndEvent, "YYYY-MM-DD h:mm").toDate(),
              allDay: false,
              id: element.id_planning
            }
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

  event = {
    title: "",
    desc: '',
    startTime: '',
    endTime: "",
    allDay: false,
    classId: ""
  };

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

  // Change current month/week/day
  next() {
    var swiper = document.querySelector('.swiper-container')['swiper'];
    swiper.slideNext();
  }

  back() {
    var swiper = document.querySelector('.swiper-container')['swiper'];
    swiper.slidePrev();
  }

  // Focus today
  today() {
    this.calendar.currentDate = new Date();
  }

  // Selected date reange and hence title changed
  onViewTitleChanged(title) {
    this.viewTitle = title;
  }

  // Calendar event was clicked
  async onEventSelected(event) {
    {
      // event.preventDefault();
      let date = event.startTime;
      const id_planning = event.id;
      const url = window.location.href;
      const id = url.substring(url.lastIndexOf('/') + 1);
      console.log(id, date, id_planning);
      this.Auth.getStudentList(id, date, id_planning);
    }
  }

  backPage(event) {
    event.preventDefault();
    const url = window.location.href;
    const id = url.substring(url.lastIndexOf('/') + 1);
    this.router.navigate(['/home/', id]);
  }

  logout() {
    this.router.navigate(['/login/']);
  }
}
