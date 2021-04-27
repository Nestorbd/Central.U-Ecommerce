import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { ACategoriaService } from 'src/app/services/a-categoria.service';

@Component({
  selector: 'app-add-categoria',
  templateUrl: './add-categoria.page.html',
  styleUrls: ['./add-categoria.page.scss'],
})
export class AddCategoriaPage implements OnInit {

  categoriaForm: FormGroup


  constructor(
    private fb: FormBuilder,
    private aCategoriaSrv: ACategoriaService,
    private router: Router
  ) { 
    this.categoriaForm = this.fb.group({
      nombre: [''],
      activo: ['']
     


    })
  }

  ngOnInit() {
  }


  onFormSubmit(){
    if (!this.categoriaForm.valid) {
      return false;
    } else {
      let categoria = {
        id:null,
        nombre: this.categoriaForm.value.nombre,
        activo: this.categoriaForm.value.activo

      }
      this.aCategoriaSrv.addCategoria(categoria)
      this.router.navigateByUrl("ver-categoria")
    }

  }
}
