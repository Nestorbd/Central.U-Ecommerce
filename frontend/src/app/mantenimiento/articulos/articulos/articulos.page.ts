import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-articulos',
  templateUrl: './articulos.page.html',
  styleUrls: ['./articulos.page.scss'],
})
export class ArticulosPage implements OnInit {

  constructor(
  private router: Router
  ) { }

  ngOnInit() {
  }


  goToCategoria(){
    this.router.navigateByUrl("ver-categoria")
  }

  goToTalla(){
    this.router.navigateByUrl("ver-talla")
  }
  goToColor(){
    this.router.navigateByUrl("ver-color")
  }
}
