import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { aCategoria } from 'src/app/model/aCategoria';
import { aColor } from 'src/app/model/aColor';
import { aTalla } from 'src/app/model/aTalla';
import { ACategoriaService } from 'src/app/services/a-categoria.service';
import { AColorService } from 'src/app/services/a-color.service';
import { ATallaService } from 'src/app/services/a-talla.service';
import { ArticuloService } from 'src/app/services/articulo.service';

@Component({
  selector: 'app-add-articulo',
  templateUrl: './add-articulo.page.html',
  styleUrls: ['./add-articulo.page.scss'],
})
export class AddArticuloPage implements OnInit {
  image: any
  articuloForm: FormGroup;
  aTalla: aTalla[];
  aColor: aColor[];
  aCategoria: aCategoria[];
  formData = new FormData();

  constructor(
    private fb: FormBuilder,
    private aTallaSrv: ATallaService,
    private aCategoriaSrv: ACategoriaService,
    private aColorSrv: AColorService,
    private articuloSrv: ArticuloService
  ) { 
    this.articuloForm = this.fb.group({
      nombre: [''],
      codigo_barra: [''],
      stock:[''],
      categoria: [''],
      talla: [''],
      color:[''],
      imagen:['']
     


    })
  }

  ngOnInit() {
    this.getTallas();
    this.getCategorias();
    this.getColores();
  }


  getTallas() {
    
    this.aTallaSrv.getData().subscribe((formularioData: any) => {
      console.log(formularioData)
      this.aTalla = formularioData;
      
    });
  }
  getCategorias() {
    
    this.aCategoriaSrv.getData().subscribe((formularioData: any) => {
      console.log(formularioData)
      this.aCategoria = formularioData;
      
    });
  }
  getColores() {
    
    this.aColorSrv.getData().subscribe((formularioData: any) => {
      console.log(formularioData)
      this.aColor = formularioData;
      
    });
  }

  selectedFile(event) {
    this.image = event.target.files[0];
  }

  onFormSubmit(){
    if (!this.articuloForm.valid) {
      return false;
    } else {

     return new Promise((resolve,reject)=>{ 
     
     this.formData.append('imagen', this.image);
      this.formData.append('nombre', this.articuloForm.value.nombre);
      this.formData.append('codigo_barra', this.articuloForm.value.codigo_barra);
      this.formData.append('stock', this.articuloForm.value.stock);
      this.formData.append('id_categoria', this.articuloForm.value.categoria);
      let i = 0
      this.articuloForm.value.color.forEach(element => {
        
        this.formData.append('colores['+ i + ']', element);
        i++
      });
      let k = 0
      this.articuloForm.value.talla.forEach(element => {
        this.formData.append('tallas['+ k + ']', element);
        k++
      });

      console.log(this.formData.getAll("tallas"))
      console.log(this.formData.getAll("colores"))

    
      
      
     
        resolve(this.articuloSrv.addArticulo(this.formData))
      })
     }
     }


  
    
  

}
