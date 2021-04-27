import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { TTarifaService } from 'src/app/services/t-tipo.service';

@Component({
  selector: 'app-add-tipo',
  templateUrl: './add-tipo.page.html',
  styleUrls: ['./add-tipo.page.scss'],
})
export class AddTipoPage implements OnInit {

  tipoForm: FormGroup


  constructor(
    private fb: FormBuilder,
    private tarifaSrv: TTarifaService,
    private router: Router
  ) { 
    this.tipoForm = this.fb.group({
      nombre: [''],
      activo: ['']
     


    })
  }

  ngOnInit() {
  }


  onFormSubmit(){
    if (!this.tipoForm.valid) {
      return false;
    } else {
      let categoria = {
        id:null,
        nombre: this.tipoForm.value.nombre,
        activo: this.tipoForm.value.activo

      }
      this.tarifaSrv.addCategoria(categoria)
      this.router.navigateByUrl("ver-tipo")
    }

  }

}
