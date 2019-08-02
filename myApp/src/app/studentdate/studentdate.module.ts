import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Routes, RouterModule } from '@angular/router';
import { IonicModule } from '@ionic/angular';
import { StudentdatePage } from './studentdate.page';
import { NgCalendarModule   } from 'ionic2-calendar';
// import { NO_ERRORS_SCHEMA} from '@angular/core';

const routes: Routes = [
  {
    path: '',
    component: StudentdatePage
  }
];

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    RouterModule.forChild(routes),
    NgCalendarModule
  ],
  declarations: [StudentdatePage]
})
export class StudentdatePageModule {}
