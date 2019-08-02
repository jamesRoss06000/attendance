import { Component, ViewChild, Inject, LOCALE_ID } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { ActivatedRoute, Router } from '@angular/router';
import { CalendarComponent } from 'ionic2-calendar/calendar';
import { formatDate } from '@angular/common';
import * as moment from 'moment';
import { AlertController } from '@ionic/angular';

@Component({
  selector: 'app-studentdate',
  templateUrl: './studentdate.page.html',
  styleUrls: ['./studentdate.page.scss'],
})
export class StudentdatePage {
  planning: any;
  authState$: Observable<boolean>;

  constructor(private Auth: AuthService, public http: HttpClient, private router: Router, private route: ActivatedRoute, private alertCtrl: AlertController, @Inject(LOCALE_ID) private locale: string) {
    this.route.queryParams.subscribe(params => {
      if (this.router.getCurrentNavigation().extras.state) {
        this.planning = this.router.getCurrentNavigation().extras.state.planning;

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
              allDay: false
            }
            this.eventSource.push(eventTmp);
          });

        });
        this.myCal.loadEvents();
      }
    });
  }

  event = {
    title: "",
    desc: '',
    startTime: '',
    endTime: "",
    allDay: false
  };

  minDate = new Date().toISOString();

  eventSource = [];
  viewTitle;

  calendar = {
    mode: 'month',
    currentDate: new Date(),
  }

  @ViewChild(CalendarComponent) myCal: CalendarComponent;

  ngOnInit() {
    this.resetEvent();
  }

  resetEvent() {
    this.event = {
      title: "",
      desc: '',
      startTime: new Date().toISOString(),
      endTime: new Date().toISOString(),
      allDay: false
    };
  }

  // Create the right event format and reload source
  addEvent() {
    let eventCopy = {
      title: this.event.title,
      startTime: new Date(this.event.startTime),
      endTime: new Date(this.event.endTime),
      allDay: this.event.allDay,
      desc: this.event.desc
    }

    if (eventCopy.allDay) {
      let start = eventCopy.startTime;
      let end = eventCopy.endTime;

      eventCopy.startTime = new Date(Date.UTC(start.getUTCFullYear(), start.getUTCMonth(), start.getUTCDate()));
      eventCopy.endTime = new Date(Date.UTC(end.getUTCFullYear(), end.getUTCMonth(), end.getUTCDate() + 1));
    }

    this.eventSource.push(eventCopy);
    this.myCal.loadEvents();
    this.resetEvent();
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
    // Use Angular date pipe for conversion
    let start = formatDate(event.startTime, 'medium', this.locale);
    let end = formatDate(event.endTime, 'medium', this.locale);

    const alert = await this.alertCtrl.create({
      header: event.title,
      subHeader: event.desc,
      message: 'From: ' + start + '<br><br>To: ' + end,
      buttons: ['OK']
    });
    alert.present();
  }

  // Time slot was clicked
  onTimeSelected(ev) {
    let selected = new Date(ev.selectedTime);
    this.event.startTime = selected.toISOString();
    selected.setHours(selected.getHours() + 1);
    this.event.endTime = (selected.toISOString());
  }

  logout() {
    this.router.navigate(['/login/']);
  }
}
