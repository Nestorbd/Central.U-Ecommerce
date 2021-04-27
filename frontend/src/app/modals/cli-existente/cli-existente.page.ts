import { Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { ModalController } from '@ionic/angular';
import { Cliente } from 'src/app/model/cliente';
import { ClienteService } from 'src/app/services/cliente.service';

@Component({
  selector: 'app-cli-existente',
  templateUrl: './cli-existente.page.html',
  styleUrls: ['./cli-existente.page.scss'],
})
export class CliExistentePage implements OnInit {

  isExistente = false;
  cliente;
  elements : number = 0;
  displayedColumns: string[] = ['Nombre', 'Tipo de cliente', 'seleccionar'];
  
  constructor(
    private modalController: ModalController,
    private clienteSrv: ClienteService
  ) { }

  ngOnInit() {
    this.getData();
  }

  @ViewChild(MatPaginator) paginator: MatPaginator;

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.cliente.filter = filterValue.trim().toLowerCase();
  }

  CloseModal(){
    this.modalController.dismiss();
  }


  getData() {
    this.clienteSrv.getData().subscribe((clientes: any) => {
      this.cliente = new MatTableDataSource<Cliente[]>(clientes[0].concat(clientes[1]))
      this.cliente.paginator = this.paginator;

      console.log(this.cliente)
    });
  }



  getEmpresa(){
    console.log("Soy Empresa")
    this.CloseModal();
  }
  getIndividual(){
    console.log("Soy individual");
    this.CloseModal();
  }
  
}
