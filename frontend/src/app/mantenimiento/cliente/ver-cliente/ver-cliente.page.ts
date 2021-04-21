import { Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { Router } from '@angular/router';
import { Cliente } from 'src/app/model/cliente';
import { ClienteService } from 'src/app/services/cliente.service';
import { DireccionService } from 'src/app/services/direccion.service';



@Component({
  selector: 'app-ver-cliente',
  templateUrl: './ver-cliente.page.html',
  styleUrls: ['./ver-cliente.page.scss'],
})
export class VerClientePage implements OnInit {

  isExistente = false;
  cliente;
  elements: number = 0;
  displayedColumns: string[] = ['Nombre', 'Tipo de cliente', 'Apellidos','Telefono','CIF','NIF','email', 'editar'];

  constructor(
    private clienteSrv: ClienteService,
    private drcSrv : DireccionService,
    private router: Router
  ) { }

  ngOnInit() {
    this.getData();
  }

  @ViewChild(MatPaginator) paginator: MatPaginator;

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.cliente.filter = filterValue.trim().toLowerCase();
  }

  getData() {
    this.clienteSrv.getData().subscribe((clientes: any) => {
      this.cliente = new MatTableDataSource<Cliente[]>(clientes[0].concat(clientes[1]))
      this.cliente.paginator = this.paginator;

      console.log(this.cliente)
    });
  }

  goToEditCliente(id: number, tf: boolean){

    this.drcSrv.setId(id);
    this.drcSrv.setTf(tf)
    this.router.navigateByUrl("cliente-direccion");
  }
}
