import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { Formulario } from 'src/app/model/formulario';
import { FormularioService } from 'src/app/services/formulario.service';


@Component({
  selector: 'app-add-input',
  templateUrl: './add-input.page.html',
  styleUrls: ['./add-input.page.scss'],
})
export class AddInputPage implements OnInit {
  image: any
  inputForm: FormGroup;
  formulario: Formulario[];
  constructor(
    private router: Router,
    private fb: FormBuilder,
    private http: HttpClient,
    private frms: FormularioService
  ) {
    this.inputForm = this.fb.group({
      apartado: [''],
      label: [''],
      type: [''],
      formControlName: [''],
      placeholder: [''],
      value: [''],
      activo: [''],


    })
  }

  ngOnInit(){

  }

  onFormSubmit(){
    if (!this.inputForm.valid) {
      return false;
    } else {
      let formulario = {
        id:null,
        apartado: this.inputForm.value.apartado,
        label: this.inputForm.value.label,
        type: this.inputForm.value.type,
        formControlName: this.inputForm.value.formControlName,
        placeholder: this.inputForm.value.placeholder,
        value: this.inputForm.value.formControlName,
        activo: this.inputForm.value.activo

      }
      this.frms.addFormulario(formulario)
      this.router.navigateByUrl("ver-input")
    }

  }

  

}
