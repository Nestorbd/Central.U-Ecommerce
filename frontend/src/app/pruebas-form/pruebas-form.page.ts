import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-pruebas-form',
  templateUrl: './pruebas-form.page.html',
  styleUrls: ['./pruebas-form.page.scss'],
})
export class PruebasFormPage implements OnInit {
  contador: number = 0;
  dynamicForm: FormGroup;
  submitted = false;
  formArray: Array<{ id: number, titulo: string, label: string, placeHolder: string, value: string, type: string, formControlName: string }> = [];
  
  constructor(
    private formBuilder: FormBuilder,
    private httpClient: HttpClient) { }

  ngOnInit() {
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
    this.formArray.push({
      "id": 6, "titulo": "Posicion", "label": "Posición del logo", "placeHolder": "Pecho.Izq, Pecho.Dch",
      "value": "posicion", "type": "text", "formControlName":"posicion"
    });
    let group = {};
    this.formArray.forEach(function (value) {
              
      group[value.value] = new FormControl('', Validators.required);
     
    })

      this.dynamicForm = this.formBuilder.group({
          numeroPrendas: ['', Validators.required],
          prendas: new FormArray([])
      });
  }

  // convenience getters for easy access to form fields
  get f() { return this.dynamicForm.controls; }
  get t() { return this.f.prendas as FormArray; }

  onChangeTickets() {
      this.contador++;

      if(this.contador<=8){
      const numberOfTickets = this.contador|| 0;
      let group = {}
      this.formArray.forEach(function (value) {
              
        group[value.value] = new FormControl('', Validators.required);
       
      })
      if (this.t.length < numberOfTickets) {
       
          for (let i = this.t.length; i < numberOfTickets; i++) {
            this.t.push(
            new FormGroup(group)
            )
              
          }
      }else {
        for (let i = this.t.length; i >= numberOfTickets; i--) {
            this.t.removeAt(i);
        }
      }
    
  }
}

  onSubmit() {
    console.log(this.t.value)

    this.t.value.forEach(element => {
      this.addLogo(element);
    });
  }

  addLogo(pedido: any ) {
    this.httpClient.post("http://localhost:80/crud_api/api/logotipos", pedido).subscribe(data => {
        console.log(data);
      }, err => {
        console.log(err);
      });

  }

}
