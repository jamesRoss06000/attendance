import { Component, OnInit } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { HttpClient } from '@angular/common/http';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-rdv',
  templateUrl: './rdv.page.html',
  styleUrls: ['./rdv.page.scss'],
})
export class RdvPage implements OnInit {
  classes: any;
  lieux: any;
  names: any;
  value: any;

  constructor(private Auth: AuthService, public http: HttpClient, private router: Router, private route: ActivatedRoute) {
    this.route.queryParams.subscribe(params => {
      if (this.router.getCurrentNavigation().extras.state) {
        this.classes = this.router.getCurrentNavigation().extras.state.classes[0];
        this.lieux = this.router.getCurrentNavigation().extras.state.classes[1];
        console.log(this.classes, this.lieux);
      }
      if (this.router.getCurrentNavigation().extras.state) {
        this.names = this.router.getCurrentNavigation().extras.state.names;
      }
    });
  }

  onSelectChange(event) {
    if (event.target) {
      this.classes.value = true;
      console.log(event.target.value);
      const chosenClasse = event.target.value;
      const url = window.location.href;
      const id = url.substring(url.lastIndexOf('/') + 1);
      this.rdvListStudents(chosenClasse, id);
      console.log("test");
    }
    else {
      this.classes.value = false;
      console.log(this.classes.value, "not working");
    }
  }

  rdvListStudents(chosenClasse, id) {
    return this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/getRdvNameList.php?id=' + id, {
      chosenClasse
    }).subscribe(data => {
      this.names = Object.values(data);
    },
      error => {
        console.log(error);
      });
  }

  createRdv(event) {
    event.preventDefault();
    const target = event.target;
    const classe = target.querySelector('#classe').value;
    const name = target.querySelector('#name').value;
    var strDate = target.querySelector('#date').value;
    let date = strDate.substring(0, 10);
    var strTime = target.querySelector('#time').value;
    let time = strTime.substring(11,16);
    var strTimeEnd = target.querySelector('#timeEnd').value;
    let timeEnd = strTimeEnd.substring(11,16);
    const lieu = target.querySelector('#lieu').value;
    const url = window.location.href;
    const id = url.substring(url.lastIndexOf('/') + 1);
    this.addRdv(classe, name, date, time, timeEnd, lieu, id);
    console.log(id, classe, name, date, time, lieu);
  }

  addRdv(classe, name, date, time, timeEnd, lieu, id) {
    this.http.post('https://attendance-ics.herokuapp.com/myApp/src/app/api/addRdv.php?id=' + id, {
      classe,
      name,
      date,
      time,
      timeEnd,
      lieu
    })
      .subscribe(data => {
        // this.names = Object.values(data);
        this.router.navigate(['/home/', id]);
      },
        error => {
          console.log(error);
        });
  }

  ngOnInit() {
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