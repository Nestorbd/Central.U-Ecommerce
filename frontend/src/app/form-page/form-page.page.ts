import { HttpClient } from '@angular/common/http';
import { Component, OnInit, ViewChild } from '@angular/core';
import { FormArray, FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { NgxMoveableComponent } from "ngx-moveable";
import { NgxSelectoComponent } from "ngx-selecto";
import { ModalController } from '@ionic/angular';
import { CliExistentePage } from '../modals/cli-existente/cli-existente.page';
import { Cliente } from '../model/cliente';
import { Cliente_Empresa } from '../model/cliente_empresa';
import { Cliente_Individual } from '../model/cliente_individual';
import { Formulario } from '../model/formulario';
import { Logotipo } from '../model/logotipo';
import { ClienteService } from '../services/cliente.service';
import { FormularioService } from '../services/formulario.service';
import { LogotipoService } from '../services/logotipo.service';
import { BocetoPage } from '../modals/boceto/boceto.page';

@Component({
  selector: 'app-form-page',
  templateUrl: './form-page.page.html',
  styleUrls: ['./form-page.page.scss'],
})
export class FormPagePage implements OnInit {
  image: any
  logoForm: FormGroup;
  isIndividual: boolean;
  isEmpresa: boolean = true;
  contador: number = 0;
  dynamicForm: FormGroup;
  submitted = false;
  formArray: Formulario[] = [];
  clienteForm: FormGroup;
  direccionForm: FormGroup;
  cliente: Cliente[];
  logotipos: Logotipo[]

  clienteIndividual: Cliente_Individual[];
  clienteEmpresa: Cliente_Empresa[];


  logosEnPantalla: Array<{id: string, imagen_png: string}> = [];



  /*@ViewChild('moveable', { static: false }) moveable: NgxMoveableComponent;
  @ViewChild('selecto', { static: false }) selecto: NgxSelectoComponent;
  cubes = [];
  targets = [];
  frameMap = new Map();
  frame = {
    translate: [0, 0],
    rotate: 0,
  };*/

  
  constructor(
    private formBuilder: FormBuilder,
    private httpClient: HttpClient,
    private frmService: FormularioService,
    private clienteSrv: ClienteService,
    private modalCtrl: ModalController,
    private logoService: LogotipoService,
    private router: Router)
     {

      this.clienteForm = this.formBuilder.group({
        nombre: [''],
        telefono: [''],
        cif: [''],
        apellidos: [''], 
        nif: [''],
        email: ['']
      })
      this.direccionForm = this.formBuilder.group({
        calle: [''],
        numero: [''],
        municipio: [''],
        provincia: [''], 
        codigo_postal: ['']
      })


      this.logoForm = this.formBuilder.group({
        nombre: [''],
        imagen: ['']
      })


     }

  ngOnInit() {

 
    this.getForm();
    let group = {};
    this.formArray.forEach(function (value) {

      group[value.value] = new FormControl('', Validators.required);

    })

    this.dynamicForm = this.formBuilder.group({
      numeroPrendas: ['', Validators.required],
      prendas: new FormArray([])
    });

   /* const cubes = [];

    for (let i = 0; i < 30; ++i) {
      cubes.push(i);
    }
    this.cubes = cubes;*/
  
  }


ionViewWillEnter(){
  this.logotipos;
}


  getForm() {
    this.frmService.getData().subscribe((formularioData: any) => {
      this.formArray = formularioData;
      console.log(formularioData)
    })

  }
  // convenience getters for easy access to form fields
  get f() { return this.dynamicForm.controls; }
  get t() { return this.f.prendas as FormArray; }

  onChangeTickets() {
    this.contador++;

    if (this.contador <= 8) {
      const numberOfTickets = this.contador || 0;
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
      } else {
        for (let i = this.t.length; i >= numberOfTickets; i--) {
          this.t.removeAt(i);
        }
      }

    }
  }

  async onSubmit() {
    console.log(this.t.value)


    if(this.isIndividual){

      let clienteIndividual = {
        id_individual: null,
        nombre: this.clienteForm.value.nombre,
        es_empresa: 0,
        apellidos: this.clienteForm.value.apellidos,
        telefono: this.clienteForm.value.telefono,
        nif: this.clienteForm.value.nif,
        email: this.clienteForm.value.email
      }
      console.log(clienteIndividual);

       this.clienteSrv.addIndividual(clienteIndividual).then(()=>{
        console.log("hola")
        this.addDirecciónIndividual().then(()=>{
          let id_individual = this.clienteSrv.getIndividualId();
        
          this.logosEnPantalla.forEach(element => {
            console.log(element.id)
            this.logoService.updateLogoToSetIndividual(parseInt(element.id), id_individual)
          });
        });
      })
     
      
    }else{
      let clienteEmpresa = {
        id_empresa: null,
        nombre: this.clienteForm.value.nombre,
        es_empresa: true,
        telefono: this.clienteForm.value.telefono,
        cif: this.clienteForm.value.cif
      }
 


      this.clienteSrv.addEmpresa(clienteEmpresa).then(()=>{
        this.addDirecciónEmpresa().then(()=>{
          let id_empresa = this.clienteSrv.getEmpresaId();
          this.logosEnPantalla.forEach(element => {
            console.log(element.id)
            this.logoService.updateLogoToSetBusiness(parseInt(element.id), id_empresa)
          });

        });
      })
    }
  }





  clienteExistente() {
    this.modalCtrl.create(
      { component: CliExistentePage }).then((modalElement) => {
        modalElement.present();

      })
  }

  addLogo() {
    this.modalCtrl.create(
      { component: BocetoPage }).then((modalElement) => {
        modalElement.present();

      })
  }


  addDirecciónIndividual(){
    return new Promise((resolve, reject)=>{
      let id_individual = this.clienteSrv.getIndividualId();
      console.log(id_individual)
    let direccion = {
      id: null,
      id_individual: id_individual,
      id_empresa: null,
      calle: this.direccionForm.value.calle,
      numero: this.direccionForm.value.numero,
      municipio: this.direccionForm.value.municipio,
      provincia: this.direccionForm.value.provincia,
      codigo_postal: this.direccionForm.value.codigo_postal,


    }
    console.log(direccion)

    resolve(this.clienteSrv.addDireccion(direccion));
  })
  }

  
  addDirecciónEmpresa(){
    return new Promise((resolve, reject)=>{
    let id_empresa = this.clienteSrv.getEmpresaId();
    console.log(id_empresa)
    let direccion = {
      id: null,
      id_individual: null,
      id_empresa: id_empresa,
      calle: this.direccionForm.value.calle,
      numero: this.direccionForm.value.numero,
      municipio: this.direccionForm.value.municipio,
      provincia: this.direccionForm.value.provincia,
      codigo_postal: this.direccionForm.value.codigo_postal,


    }

    resolve(this.clienteSrv.addDireccion(direccion));
  })
  }








  selectedFile(event) {
    this.image = event.target.files[0];
  }

  onClick() {
    if (!this.logoForm.valid) {
      return false;
    } else {
      const formData = new FormData();
      formData.append('imagen', this.image);
      formData.append('nombre', this.logoForm.value.nombre)

      this.logoService.addLogo(formData).then(()=>{
       let id = this.logoService.getIdLogo();
       let id_aux = id.toString()
       let imagen = this.logoService.getIdImagen();
       const logo = {"id": id_aux, "imagen_png": imagen}
       
         this.logosEnPantalla.push(logo)
         console.log(this.logosEnPantalla)
    })
    }


  
}






////////////////////////MOVEABLE LOGOS
///////////////////////////////////////////////////



}
