import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { tTipo } from 'src/app/model/tTipo';
import { CTarifaService } from 'src/app/services/t-categoria.service';
import { TTarifaService } from 'src/app/services/t-tipo.service';

@Component({
  selector: 'app-add-categoria-t',
  templateUrl: './add-categoria-t.page.html',
  styleUrls: ['./add-categoria-t.page.scss'],
})
export class AddCategoriaTPage implements OnInit {
  categoriaForm: FormGroup
  tTipo: tTipo[];

  constructor(
    private fb: FormBuilder,
    private aCategoriaSrv: CTarifaService,
    private tipoSrv: TTarifaService,
    private router: Router
  ) { 
    this.categoriaForm = this.fb.group({
      nombre: [''],
      activo: [''],
      tipo: ['']
     


    })
  }

  ngOnInit() {
    this.getData()
    }

    getData() {
    
      this.tipoSrv.getData().subscribe((formularioData: any) => {
        this.tTipo = formularioData;

      });
  
     
    }

  onFormSubmit(){
    if (!this.categoriaForm.valid) {
      return false;
    } else {
      let categoria = {
        id:null,
        nombre: this.categoriaForm.value.nombre,
        activo: this.categoriaForm.value.activo,
        tipos: this.categoriaForm.value.tipo

      }
      console.log(categoria)
      this.aCategoriaSrv.addCategoria(categoria)
     this.router.navigateByUrl("ver-categoria-t")
    }

  }

}
