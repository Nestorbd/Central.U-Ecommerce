import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { ATallaService } from 'src/app/services/a-talla.service';

@Component({
  selector: 'app-add-talla',
  templateUrl: './add-talla.page.html',
  styleUrls: ['./add-talla.page.scss'],
})
export class AddTallaPage implements OnInit {

  tallaForm: FormGroup


  constructor(
    private fb: FormBuilder,
    private aTallaSrv: ATallaService,
    private router: Router
  ) { 
    this.tallaForm = this.fb.group({
      nombre: [''],
      activo: ['']
     


    })
  }

  ngOnInit() {
  }


  onFormSubmit(){
    if (!this.tallaForm.valid) {
      return false;
    } else {
      let categoria = {
        id:null,
        nombre: this.tallaForm.value.nombre,
        activo: this.tallaForm.value.activo

      }
      this.aTallaSrv.addCategoria(categoria)
      this.router.navigateByUrl("ver-talla")
    }

  }
}
