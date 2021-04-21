import { Component, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { Router } from '@angular/router';
import { Cliente } from 'src/app/model/cliente';
import { Direccion } from 'src/app/model/direccion';
import { Formulario } from 'src/app/model/formulario';
import { Logotipo } from 'src/app/model/logotipo';
import { ClienteService } from 'src/app/services/cliente.service';
import { DireccionService } from 'src/app/services/direccion.service';
import { FormularioService } from 'src/app/services/formulario.service';
import { LogotipoService } from 'src/app/services/logotipo.service';

@Component({
  selector: 'app-cliente-direccion',
  templateUrl: './cliente-direccion.page.html',
  styleUrls: ['./cliente-direccion.page.scss'],
})
export class ClienteDireccionPage implements OnInit {
  id: number;
  tf: boolean;
  direccion: Direccion[];
  clientes: Cliente[];
  logotipo: Logotipo[];
  formulario;
  contentEditable: boolean = false;
  editField: string;
  elements : number = 0;
  displayedColumns: string[] = ['calle', 'numero', 'municipio', 'provincia', 'codigo_postal', 'editar'];

  isEmpresa: boolean;

  clientUpdateForm: FormGroup;


  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.formulario.filter = filterValue.trim().toLowerCase();
  }


  @ViewChild(MatPaginator) paginator: MatPaginator;
  

  constructor(
    private dirSrv: DireccionService,
    private clienteSrv: ClienteService,
    private fb: FormBuilder,
    private frmService: FormularioService,
    private router: Router,
    private logoService: LogotipoService
  ) {

    this.clientUpdateForm = this.fb.group({
      nombre: [''],
      apellidos: [''],
      telefono: [''],
      nif: [''],
      cif: [''],
      email: ['']
    })

  }

  ngOnInit() {

  }


  ionViewWillEnter() {
    console.log(this.displayedColumns)
    this.elements;
    this.contentEditable
    this.id = this.dirSrv.getId();
    this.tf = this.dirSrv.getTf();
    this.getData();
    this.getLogo();
    this.clienteSrv.getClienteByID(this.id, this.tf).subscribe((p) => {

      if (p.id_empresa >= 0) {
        this.clienteSrv.setEmpresaId(p.id_empresa);
        this.isEmpresa = true;
        this.clientUpdateForm = this.fb.group({
          nombre: p.nombre,
          telefono: p.telefono,
          cif: p.CIF
        })

      } else {
        
        this.isEmpresa = false;
        let cliente = Object.entries(p)
        let clienteAux = cliente[0]
        this.clienteSrv.setIndividualId(clienteAux[1].id_individual);
        this.clientUpdateForm = this.fb.group({

          nombre: clienteAux[1].nombre,
          apellidos: clienteAux[1].apellidos,
          telefono: clienteAux[1].telefono,
          nif: clienteAux[1].NIF,
          email: clienteAux[1].email
        })

      }

    })


  }

  getData() {

    this.dirSrv.getDireccionByUserId(this.id, this.tf).subscribe((direccion: any) => {
      this.formulario = direccion;
      this.formulario = new MatTableDataSource<Formulario[]>(direccion);
      this.formulario.paginator = this.paginator;
      console.log(this.formulario)
      direccion.forEach(element =>{
        this.elements++;
      })
    });
  }




  onFormSubmit(){
    if(this.isEmpresa){
      let id = this.clienteSrv.getEmpresaId()
      if(!this.clientUpdateForm.valid){
        return false;
      }else{
        let cliente_empresa = {
          id_empresa: id,
          nombre: this.clientUpdateForm.value.nombre,
          es_empresa: true,
          telefono: this.clientUpdateForm.value.telefono,
          cif: this.clientUpdateForm.value.cif,
          
        }
         this.clienteSrv.updateEmpresa(id, cliente_empresa)
      
       }
    }else{
      let id = this.clienteSrv.getIndividualId()
      if(!this.clientUpdateForm.valid){
        return false;
      }else{
        let cliente_individual = {
          id_individual: id,
          nombre: this.clientUpdateForm.value.nombre,
          apellidos: this.clientUpdateForm.value.apellidos,
          es_empresa: false,
          telefono: this.clientUpdateForm.value.telefono,
          nif: this.clientUpdateForm.value.nif,
          email: this.clientUpdateForm.value.email,
          
        }
        this.clienteSrv.updateIndividual(id, cliente_individual)
    }
    
  }

  }


  // DIRECCIÓN
///////////////////////////////////////////////////////////////////////////


changeValue(event: any){
  console.log(event.target.textContent)
  this.editField = event.target.textContent;

}


updateList(columna: string, id:number){
 console.log(columna, id, this.editField)
  
  this.dirSrv.actualizarDireccion(id, columna, this.editField)
}

eliminar(id: number){
  this.dirSrv.eliminarDireccionById(id);
}



editar(){
  this.contentEditable = true;
  console.log(this.contentEditable)
}
 // LOGOTIPOS
///////////////////////////////////////////////////////////////////////////


getLogo() {
  this.logoService.getLogos().subscribe((logotipo: any) => {
    this.logotipo = logotipo;
    console.log(this.logotipo)

  });
}


}
