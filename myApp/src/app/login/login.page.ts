import { Component, OnInit } from '@angular/core';
import { AuthService } from '../services/auth.service';
@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})

// Ci-dessous : Une classe est créée automatiquement dans 
// le fichier.ts de chaque composant. 
export class LoginPage implements OnInit {
  // On place toutes les dépendances dans le constructeur, qui 
  // est appelé sur l'initialisation du composant.
  constructor(private Auth: AuthService) { }

  ngOnInit() {
  }
  loginUser(event){
    // event.preventDefault();
    const target = event.target;
    const email = target.querySelector('#email').value;
    const password = target.querySelector('#password').value;
    this.Auth.getUserDetails(email, password);
  }
}