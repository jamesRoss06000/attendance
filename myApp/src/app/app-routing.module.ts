import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';
import '@ionic/core';
import { BrowserModule }    from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';

const routes: Routes = [
  { path: '', redirectTo: 'login', pathMatch: 'full' },
  { path: 'home/:id', loadChildren: './home/home.module#HomePageModule' },
  { path: 'login', loadChildren: './login/login.module#LoginPageModule' },
  { path: 'cours/:id', loadChildren: './cours/cours.module#CoursPageModule' },
  { path: 'list-students/:id', loadChildren: './list-students/list-students.module#ListStudentsPageModule' },
  { path: 'agenda/:id', loadChildren: './agenda/agenda.module#AgendaPageModule' },
  { path: 'studentdate/:id', loadChildren: './studentdate/studentdate.module#StudentdatePageModule' },
  { path: 'rdv', loadChildren: './rdv/rdv.module#RdvPageModule' },
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules }), BrowserModule, HttpClientModule
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }