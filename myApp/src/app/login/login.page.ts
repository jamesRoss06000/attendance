import { Component, OnInit } from '@angular/core';
// import { HttpClient } from '@angular/common/http';
// Voir ci-dessus : Les composants et modules Angular sont 
// importés sur chaque page dont nous avons besoin.
import { AuthService } from '../services/auth.service';
// On importe le fichier de service qu'on a créé (nous verrons cela plus
// en détail bientôt). Il s'agit d'un fichier qui a des fonctions et 
// sert également de lien entre les différentes pages de l'application.
@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
// En haut : Détails des composants tels que le sélecteur et les 
// chemins de fichiers pour les fichiers HTML et CSS.

// Ci-dessous : Une classe est créée automatiquement dans le fichier.ts de chaque composant. 
export class LoginPage implements OnInit {
  // On place toutes les dépendances dans le constructeur, qui est appelé sur l'initialisation du composant.
  constructor(private Auth: AuthService) { }

  ngOnInit() {
  }
  // Ci-dessous se trouve la fonction que l'utilisateur appelle à partir de la page HTML, 
  // lorsqu'il soumet les détails de l'utilisateur.
  loginUser(event){
    event.preventDefault();
    const target = event.target;
    const email = target.querySelector('#email').value;
    const password = target.querySelector('#password').value;
// On met les deux valeurs dans des variables qui sont passées à la page de service'auth.service.ts'
//  comme arguments dans la fonction getUserDetails()
    this.Auth.getUserDetails(email, password);
    // console.log(email, password, "test");
  }
}