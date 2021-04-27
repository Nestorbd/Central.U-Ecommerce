import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { tCategoria } from 'src/app/model/tCategoria';
import { tTipo } from 'src/app/model/tTipo';
import { CTarifaService } from 'src/app/services/t-categoria.service';
import { TTarifaService } from 'src/app/services/t-tipo.service';
import { TarifaService } from 'src/app/services/tarifa.service';

@Component({
  selector: 'app-add-tarifas',
  templateUrl: './add-tarifas.page.html',
  styleUrls: ['./add-tarifas.page.scss'],
})
export class AddTarifasPage implements OnInit {

  tCategoria: tCategoria[];
  tTipo: tTipo[];
  tarifaForm: FormGroup


  constructor(
    private fb: FormBuilder,
    private ttarifaSrv: TTarifaService,
    private ctarifaSrv: CTarifaService,
    private tarifaSrv: TarifaService,
    private router: Router
  ) { 
    this.tarifaForm = this.fb.group({
      nombre: [''],
      precio: [''],
      id_categoria: [''],
      id_tipo: ['']
     


    })
  }

  ngOnInit() {
    this.getCategoria();
    this.getTipo();
  }


  onFormSubmit(){
    if (!this.tarifaForm.valid) {
      return false;
    } else {
      let categoria = {
        id:null,
        nombre: this.tarifaForm.value.nombre,
        activo: null,
        precio: this.tarifaForm.value.precio,
        fecha_creacion: null,
        fecha_actualizacion: null,
        id_categoria: this.tarifaForm.value.id_categoria,
        id_tipo: this.tarifaForm.value.id_tipo

      }
     this.tarifaSrv.addCategoria(categoria)
      this.router.navigateByUrl("ver-tipo")
    }

  }


  getCategoria() {
    
    this.ctarifaSrv.getData().subscribe((formularioData: any) => {
      this.tCategoria = formularioData;
 
    });
  }
  getTipo() {
    
    this.ttarifaSrv.getData().subscribe((formularioData: any) => {
      this.tTipo = formularioData;
 
    });
  }

}
