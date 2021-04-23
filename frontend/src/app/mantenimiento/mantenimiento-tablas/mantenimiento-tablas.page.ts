import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-mantenimiento-tablas',
  templateUrl: './mantenimiento-tablas.page.html',
  styleUrls: ['./mantenimiento-tablas.page.scss'],
})
export class MantenimientoTablasPage implements OnInit {

  constructor(
    private router: Router
  ) { }

  ngOnInit() {
  }

  goToFormulario(){
    this.router.navigateByUrl("ver-input")
  }

  goToCliente(){
    this.router.navigateByUrl("ver-cliente")
  }

  goToArticulo(){
    this.router.navigateByUrl("articulos");
  }
}
