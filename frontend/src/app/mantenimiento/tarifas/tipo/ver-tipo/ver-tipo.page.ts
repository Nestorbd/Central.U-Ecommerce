import { Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { Router } from '@angular/router';
import { tTipo } from 'src/app/model/tTipo';
import { TTarifaService } from 'src/app/services/t-tipo.service';

@Component({
  selector: 'app-ver-tipo',
  templateUrl: './ver-tipo.page.html',
  styleUrls: ['./ver-tipo.page.scss'],
})
export class VerTipoPage implements OnInit {
  tTipo;
  contentEditable: boolean = false;
  editField: string;
  elements : number = 0;
  displayedColumns: string[] = ['nombre', 'activo', 'editar'];
  

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.tTipo.filter = filterValue.trim().toLowerCase();
  }


  @ViewChild(MatPaginator) paginator: MatPaginator;

  constructor(
    private tipoSrv: TTarifaService,
    private router: Router
  ) { }

  ngOnInit() {
    
    this.getData();
  }

  ngAfterViewInit() {
   
  }
  changeValue(event: any){
    this.editField = event.target.textContent;
  
  }


  updateList(columna: string, id:number){

    
    this.tipoSrv.actualizarFormulario(id, columna, this.editField)
  }

  ionViewWillEnter(){
    this.elements;
    this.contentEditable
  }


  getData() {
    
    this.tipoSrv.getData().subscribe((formularioData: any) => {
      this.tTipo = formularioData;
      this.tTipo = new MatTableDataSource<tTipo[]>(formularioData);
      this.tTipo.paginator = this.paginator;
      console.log(this.tTipo)
      formularioData.forEach(element =>{
        this.elements++;
      })
    });

   
  }

  goToAddCategoria(){
    this.router.navigateByUrl("add-tipo");
  }
  editar(){
    this.contentEditable = true;
    console.log(this.contentEditable)
  }

}
