import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { LogotipoService } from '../../../services/logotipo.service';

@Component({
  selector: 'app-update-logo',
  templateUrl: './update-logo.page.html',
  styleUrls: ['./update-logo.page.scss'],
})
export class UpdateLogoPage implements OnInit {
  logoUpdateForm: FormGroup;

  constructor(
    private logoService: LogotipoService,
    public fb: FormBuilder,
    private router: Router

  ) {
    this.logoUpdateForm = this.fb.group({
      nombre: ['']
    })
  }

  ngOnInit() {
    let id = this.logoService.getCurrentLogoId();
    console.log(id);
    

    this.logoService.getLogoById(id).subscribe((p) => {
      this.logoUpdateForm = this.fb.group({
        nombre: p["nombre"],
       
      })
    })
  }

  onFormSubmit(){
    let id = this.logoService.getCurrentLogoId();
    if(!this.logoUpdateForm.valid){
      return false;
    }else{
      let logotipo = {
        id: id,
        nombre: this.logoUpdateForm.value.nombre,
        imagen: null
      }
      this.logoService.updateLogo(id, logotipo)
      this.router.navigateByUrl("home");
      }
    }
  }

