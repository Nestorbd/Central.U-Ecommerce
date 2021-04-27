import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { AColorService } from 'src/app/services/a-color.service';

@Component({
  selector: 'app-add-color',
  templateUrl: './add-color.page.html',
  styleUrls: ['./add-color.page.scss'],
})
export class AddColorPage implements OnInit {

  colorForm: FormGroup


  constructor(
    private fb: FormBuilder,
    private aColorSrv: AColorService,
    private router: Router
  ) { 
    this.colorForm = this.fb.group({
      nombre: [''],
      activo: ['']
     


    })
  }

  ngOnInit() {
  }


  onFormSubmit(){
    if (!this.colorForm.valid) {
      return false;
    } else {
      let color = {
        id:null,
        nombre: this.colorForm.value.nombre,
        activo: this.colorForm.value.activo

      }
      this.aColorSrv.addCategoria(color)
      this.router.navigateByUrl("ver-color")
    }

  }

}
