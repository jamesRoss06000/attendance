import { Component, OnInit } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { ActivatedRoute, Router } from '@angular/router';
import { ChangeDetectorRef } from '@angular/core';

@Component({
  selector: 'app-rdv',
  templateUrl: './rdv.page.html',
  styleUrls: ['./rdv.page.scss'],
})
export class RdvPage implements OnInit {
  classes: any;
  names: any;
  authState$: Observable<boolean>;
  value: any;

  constructor(private Auth: AuthService, public http: HttpClient, private router: Router, private route: ActivatedRoute, private changeRef: ChangeDetectorRef) {
    this.route.queryParams.subscribe(params => {
      if (this.router.getCurrentNavigation().extras.state) {
        this.classes = this.router.getCurrentNavigation().extras.state.classes;
      }
      if (this.router.getCurrentNavigation().extras.state) {
        this.names = this.router.getCurrentNavigation().extras.state.names;
      }
    });
  }

  onSelectChange(event, i) {
    if (event.target) {
      this.classes.value = true;
      console.log(event.target.value);
      const chosenClasse = event.target.value;
      const url = window.location.href;
      const id = url.substring(url.lastIndexOf('/') + 1);
      this.rdvListStudents(chosenClasse, id);
    }
    else {
      this.classes.value = false;
      console.log(this.classes.value, "not working");
    }
  }

  rdvListStudents(chosenClasse, id){
    return this.http.post('http://localhost/Attendance App/myApp/src/app/api/getRdvNameList.php?id=' + id, {
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
    console.log(this.names, this.classes);
  }

  ngOnInit() {
    setTimeout(() => {
      this.changeRef.detectChanges();
    }, 2000)
  }

  backPage(event) {
    event.preventDefault();
    const url = window.location.href;
    const id = url.substring(url.lastIndexOf('/') + 1);
    this.router.navigate(['/home/', id]);
  }
}
