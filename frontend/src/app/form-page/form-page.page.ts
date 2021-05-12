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
import { ArticuloService } from '../services/articulo.service';
import { Articulo } from '../model/articulo';
import { MatCarousel, MatCarouselComponent } from 'ng-mat-carousel';
import { Pedido } from '../model/pedido';
import { MatStepper } from '@angular/material/stepper';

import { aTalla } from '../model/aTalla';
import { aColor } from '../model/aColor';
import { AColorService } from '../services/a-color.service';
import { ACategoriaService } from '../services/a-categoria.service';
import { aCategoria } from '../model/aCategoria';
import { ATallaService } from '../services/a-talla.service';
import { CTarifaService } from '../services/t-categoria.service';
import { TTarifaService } from '../services/t-tipo.service';
import { tTipo } from '../model/tTipo';
import { tCategoria } from '../model/tCategoria';


@Component({
  selector: 'app-form-page',
  templateUrl: './form-page.page.html',
  styleUrls: ['./form-page.page.scss'],
})

export class FormPagePage implements OnInit {
  index: number;
  image: any
  logoForm: FormGroup;
  isIndividual: boolean;
  isEmpresa: boolean = true;
  contadorT: number = 0;
  contador: number = 0;
  dynamicForm: FormGroup;
  submitted = false;
  arr = Array;
  tTarifa: number = 0;
  tCategoriaId: number;
  tTipoId: number;

  isTCategoria: boolean = false;
  isTTipo: boolean = false;

  formArray: FormGroup;
  clienteForm: FormGroup;
  direccionForm: FormGroup;
  pedidoForm: FormGroup;
  cliente: Cliente[];
  logotipos: Logotipo[]
  articulo: Articulo[]
  clienteIndividual: Cliente_Individual[];
  clienteEmpresa: Cliente_Empresa[];
  aTalla: aTalla[];
  aColor: aColor[];
  aCategoria: aCategoria[];
  tarifas: FormArray;
  tCategoria: tCategoria[];
  tTipo: tTipo[];
  logosEnPantalla: Array<{ id: string, imagen_png: string }> = [];


  pedido: Array<{

    id: number, esta_firmado: boolean, parte_trabajo: string,
    fecha_terminacion_trabajo: string,
    validado: boolean, id_estado: number, id_individual: number, id_empresa: number, id_usuario: number,
    logotipos: Array<[]>, tarifas: Array<[]> , articulos: Array<[]>

  }> = [];


  patrones: Array<{}> = [{}]
  tallasFormGroup: FormGroup


  constructor(
    private formBuilder: FormBuilder,
    private httpClient: HttpClient,
    private frmService: FormularioService,
    private clienteSrv: ClienteService,
    private modalCtrl: ModalController,
    private logoService: LogotipoService,
    private aTallaSrv: ATallaService,
    private aColorSrv: AColorService,
    private aCategoriaSrv: ACategoriaService,
    private articuloSrv: ArticuloService,
    private ttarifaSrv: TTarifaService,
    private ctarifaSrv: CTarifaService,
    private router: Router) {

    this.pedidoForm = this.formBuilder.group({
      esta_firmado: [''],
      parte_trabajo: [''],
      fecha_terminacion_trabajo: [''],
      validado: [''],

    })


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
    this.getCategoria();
    this.getTipo();


    this.getTallas();
    this.getCategorias();
    this.getColores();

    this.getForm();
    this.getArticulo();
    let group = {};
    // this.formArray.forEach(function (value) {

    //   group[value.value] = new FormControl('', Validators.required);

    // })

    this.dynamicForm = this.formBuilder.group({
      numeroPrendas: ['', Validators.required],
      articulo: new FormArray([]),
      tarifas: new FormArray([])
    });


  }


  ionViewWillEnter() {
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
  get t() { return this.f.articulo as FormArray; }
  get p() { return this.f.tarifas as FormArray; }


  onChangeTarifa(){
    this.contadorT++;
    

    if (this.contador <= 8) {
      const numberOfTickets = this.contadorT || 0;
      let group = {}
      // this.formArray.forEach(function (value) {

      //   group[value.value] = new FormControl('', Validators.required);

      // })
   
      if (this.p.length < numberOfTickets) {

        for (let i = this.t.length; i < numberOfTickets; i++) {
          this.p.push(this.formBuilder.group({
            id_categoria: ['', Validators.required],
            id_tipo: ['', Validators.required],
            id_tarifa: ['', Validators.required]
          })

          )
        }


      } else {
        for (let i = this.t.length; i >= numberOfTickets; i--) {
          this.t.removeAt(i);
        }
      }

    
    }
 
  
  }
  onChangeTickets() {
    this.contador++;
    

    if (this.contador <= 8) {
      const numberOfTickets = this.contador || 0;
      let group = {}
      // this.formArray.forEach(function (value) {

      //   group[value.value] = new FormControl('', Validators.required);

      // })
   
      if (this.t.length < numberOfTickets) {

        for (let i = this.t.length; i < numberOfTickets; i++) {
          this.t.push(this.formBuilder.group({
            id_articulo: ['', Validators.required],
            id_color: ['', Validators.required],
            id_talla: ['', Validators.required],
            cantidad: ['', Validators.required]
          })

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
    let id_logos = []
    this.logosEnPantalla.forEach(element => {

      id_logos.push(element.id)
    });
    console.log(id_logos)

    if (this.isIndividual) {

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

      this.clienteSrv.addIndividual(clienteIndividual).then(() => {
        console.log("hola")
        this.addDirecciónIndividual().then(() => {
          let id_individual = this.clienteSrv.getIndividualId();


          let json = {
            "id": 1, "esta_firmado": this.pedidoForm.value.esta_firmado, "parte_trabajo": this.pedidoForm.value.parte_trabajo,
            "fecha_terminacion_trabajo": this.pedidoForm.value.fecha_terminacion_trabajo,
            "validado": this.pedidoForm.value.validado, "id_estado": 1, "id_individual": id_individual, "id_empresa": null, "id_usuario": 1,
            "logotipos": id_logos, "tarifas": this.p.value, "articulos": this.t.value
          }
          this.pedido.push(json);
          console.log(json)
          console.log(this.pedido)
          this.logosEnPantalla.forEach(element => {
            console.log(element.id)
            this.logoService.updateLogoToSetIndividual(parseInt(element.id), id_individual)
          });
        });
      })


    } else {
      let clienteEmpresa = {
        id_empresa: null,
        nombre: this.clienteForm.value.nombre,
        es_empresa: true,
        telefono: this.clienteForm.value.telefono,
        cif: this.clienteForm.value.cif
      }



      // this.clienteSrv.addEmpresa(clienteEmpresa).then(()=>{
      //   this.addDirecciónEmpresa().then(()=>{
      //     let id_empresa = this.clienteSrv.getEmpresaId();
      //     this.logosEnPantalla.forEach(element => {
      //       console.log(element.id)
      //       this.logoService.updateLogoToSetBusiness(parseInt(element.id), id_empresa)
      //     });

      //   });
      // })
    }
  }


  public onStepChange(event: any): void {
    this.index = (event.selectedIndex);
  }

  clienteExistente() {
    this.modalCtrl.create(
      {
        component: CliExistentePage,
        cssClass: 'cli-modal'
      }).then((modalElement) => {
        modalElement.present();

      })
  }

  addLogo() {
    this.modalCtrl.create(
      {
        component: BocetoPage,
        cssClass: 'boceto-modal'
      }).then((modalElement) => {
        modalElement.present();

      })
  }


  addDirecciónIndividual() {
    return new Promise((resolve, reject) => {
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


  addDirecciónEmpresa() {
    return new Promise((resolve, reject) => {
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

      this.logoService.addLogo(formData).then(() => {
        let id = this.logoService.getIdLogo();
        let id_aux = id.toString()
        let imagen = this.logoService.getIdImagen();
        const logo = { "id": id_aux, "imagen_png": imagen }

        this.logosEnPantalla.push(logo)
        console.log(this.logosEnPantalla)
      })
    }



  }






  ////////////////  ARTICULOS
  //////////////////////////////////////////

  getArticulo() {

    this.articuloSrv.getData().subscribe((formularioData: any) => {
      console.log(formularioData)
      this.articulo = formularioData;

    });


  }


  getArticuloId(id: number, imagen: string) {
    let i = 0;



    this.t.value.forEach(element => {
      i++;
      if (i == this.index) {
        element.id_articulo = id

      }

    });
    this.articuloSrv.setId(id);
    this.articuloSrv.setImagen(imagen);
  }



  /////////COLOR TALLA
  ///////////////////////////////////


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


  ///////////////////TARIFAS
  ///////////////////////////////////////////

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



  setCategoria($event) {
    this.tCategoriaId = $event.detail['value']
    console.log(this.tCategoriaId)
    this.isTCategoria = true;
  }

  setTipo($event) {
    this.tTipoId = $event.detail['value']
    console.log(this.tTipoId)
    this.isTTipo = true;
  }

  tTrabajo(){
    this.tTarifa++;
  }
}

