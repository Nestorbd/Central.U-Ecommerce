import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { Logotipo } from '../model/logotipo';
import { LogotipoService } from '../services/logotipo.service';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {


  logotipo: Logotipo[];

  constructor(
    private logoService: LogotipoService,
    private router: Router
  ) {}


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
