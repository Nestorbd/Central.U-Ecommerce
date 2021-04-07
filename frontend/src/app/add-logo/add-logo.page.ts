import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { Logotipo } from '../model/logotipo';
import { LogotipoService } from '../services/logotipo.service';

@Component({
  selector: 'app-add-logo',
  templateUrl: './add-logo.page.html',
  styleUrls: ['./add-logo.page.scss'],
})
export class AddLogoPage implements OnInit {

  logoForm: FormGroup;
  logotipo: Logotipo[];
  constructor(
    private logoService: LogotipoService,
    private router: Router,
    private fb: FormBuilder
  ) {
    this.logoForm = this.fb.group({
      nombre: ['']
    })
  }

  ngOnInit(){

  }

  onFormSubmit() {
    if (!this.logoForm.valid) {
      return false;
    } else {
      let logo = {
        id: null,
        nombre: this.logoForm.value.nombre,
        imagen: null

      }
      console.log(logo)
      this.logoService.addLogo(logo)
      this.router.navigateByUrl("home")
    }
  }

}
