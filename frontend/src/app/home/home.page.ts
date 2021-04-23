import { Component, OnInit, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { IonSlides, MenuController, PopoverController } from '@ionic/angular';
import { Logotipo } from '../model/logotipo';
import { LogotipoService } from '../services/logotipo.service';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage implements OnInit {


  logotipo: Logotipo[];

  constructor(
    private logoService: LogotipoService,
    private router: Router,
    private menu: MenuController
  ) {
  }

  ngOnInit(){
    this.getLogo()
  
  }

  goToNewInvoice(){
    this.router.navigateByUrl("form-page")
  }

  goToCRUD(){
    this.router.navigateByUrl("mantenimiento-tablas");
  }

  toggleMenu() {
        this.menu.enable(true, 'tienda');
        this.menu.open('tienda');

  }


  getLogo() {
    this.logoService.getLogos().subscribe((logotipo: any) => {
      this.logotipo = logotipo;
      console.log(this.logotipo)

    });
  }

  getLogoById(id: number){
    console.log(id+ " hola");
    this.logoService.getLogoById(id).subscribe(( logo : any) => {
    
    })
  }

  deleteLogo(id:number){
    console.log(id)
    this.logoService.deleteLogo(id)
  }

  addLogo(){
   this.router.navigateByUrl("add-logo");
  }

  updateLogo(id: number){
    this.logoService.setCurrentLogoId(id)

    this.router.navigateByUrl("update-logo")
  }
}
