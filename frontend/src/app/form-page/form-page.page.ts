import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-form-page',
  templateUrl: './form-page.page.html',
  styleUrls: ['./form-page.page.scss'],
})
export class FormPagePage implements OnInit {
  isLinear = false;
  isTrabajo = false;
  isPrenda = false;
  isColor = false;
  porcentaje: number;
  pedidoForm1: FormGroup;
  nPrendas: number = 1;
  
  prendaArray: Array<{prendas: number, formName: string}> = [];

  formArray: Array<{ id: number, titulo: string, label: string, placeHolder: string, value: string, type: string, formControlName: string }> = [];
  

  constructor(
    private fb: FormBuilder,
    private httpClient: HttpClient) { 
 
   
    
    
  }

  ngOnInit() {
  
    this.porcentaje = 0
    this.formArray.push({
      "id": 1, "titulo": "Tipo de prenda", "label": "Prenda", "placeHolder": "Camiseta, Polo, Polar",
      "value": "prenda", "type": "text", "formControlName":"prenda"
    });
    this.formArray.push({
      "id": 2, "titulo": "Color", "label": "Color", "placeHolder": "Amarillo, Rojo, Azul...",
      "value": "color", "type": "text", "formControlName":"color"
    });

    this.formArray.push({
      "id": 3, "titulo": "Talla", "label": "Talla", "placeHolder": "L, M, S...",
      "value": "talla", "type": "text", "formControlName":"talla"
    });

    this.formArray.push({
      "id": 4, "titulo": "Ref. Prenda", "label": "Ref. Prenda", "placeHolder": "504.20.50 ...",
      "value": "refprenda", "type": "number", "formControlName":"refprenda"
    });

    this.formArray.push({
      "id": 5, "titulo": "Cantidad", "label": "Cantidad del producto", "placeHolder": "50",
      "value": "cantidad", "type": "number", "formControlName":"cantidad"
    });
    // this.formArray.push({
    //   "id": 6, "titulo": "Posicion", "label": "Posición del logo", "placeHolder": "Pecho.Izq, Pecho.Dch",
    //   "value": "posicion", "type": "text", "formControlName":"posicion"
    // });
 
    this.prendaArray.push({"prendas":1, "formName": "pedidosForm"})
    let group={};
    
    this.formArray.forEach(function (value) {
      group[value.value] = new FormControl('', Validators.required);
      
    })
    this.pedidoForm1 = new FormGroup(group); 
    
    

    console.log(group)


  }


  get f() { return this.pedidoForm1.controls; }
  get t() { return this.f.tickets as FormArray; }


  ionViewWillEnter() {
    this.porcentaje
    this.nPrendas
    
  }




  addPrenda(){
    this.nPrendas++;
    const numberOfTickets = this.nPrendas || 0;
    let group={};
    if (this.nPrendas < numberOfTickets) {
        for (let i = this.nPrendas; i < numberOfTickets; i++) {
          this.formArray.forEach(function (value) {
            group[value.value] = new FormControl('', Validators.required);
            
          })
          this.pedidoForm1 = new FormGroup(group); 
        }
    
    }
    this.prendaArray.push({"prendas": this.nPrendas, "formName": "pedidosForm"});
  }

  onFormSubmit() {
    if (!this.pedidoForm1.valid) {
      return false;
    } else {

      let pedido=[]

      pedido = this.pedidoForm1["value"]

      alert('SUCCESS!! :-)\n\n' + JSON.stringify(this.t.value, null, 4));
     // this.addLogo(pedido);
      

      
    }
  }

  addLogo(pedido: any ) {
    this.httpClient.post("http://localhost:80/crud_api/api/logotipos", pedido).subscribe(data => {
        console.log(data);
      }, err => {
        console.log(err);
      });

  }
  
}



