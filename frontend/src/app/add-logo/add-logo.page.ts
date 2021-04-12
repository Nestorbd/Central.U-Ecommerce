import { HttpClient } from '@angular/common/http';
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
  image: any
  logoForm: FormGroup;
  logotipo: Logotipo[];
  constructor(
    private logoService: LogotipoService,
    private router: Router,
    private fb: FormBuilder,
    private http: HttpClient
  ) {
    this.logoForm = this.fb.group({
      nombre: [''],
      imagen: ['']
    })
  }

  ngOnInit() {

  }

  selectedFile(event) {
    this.image = event.target.files[0];
  }

  onClick() {
    if (!this.logoForm.valid) {
      return false;
    } else {
      const formData = new FormData();
      formData.append('imagen', this.image);
      formData.append('nombre', this.logoForm.value.nombre)

      this.logoService.addLogo(formData)
      this.router.navigateByUrl("home")
    }
  }



}
