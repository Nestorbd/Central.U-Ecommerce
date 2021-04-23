import { Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { Router } from '@angular/router';
import { element } from 'protractor';
import { aCategoria } from 'src/app/model/aCategoria';
import { Formulario } from 'src/app/model/formulario';
import { ACategoriaService } from 'src/app/services/a-categoria.service';
import { FormularioService } from 'src/app/services/formulario.service';

@Component({
  selector: 'app-ver-categoria',
  templateUrl: './ver-categoria.page.html',
  styleUrls: ['./ver-categoria.page.scss'],
})
export class VerCategoriaPage implements OnInit {

  aCategoria;
  contentEditable: boolean = false;
  editField: string;
  elements : number = 0;
  displayedColumns: string[] = ['nombre', 'activo', 'editar'];
  

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.aCategoria.filter = filterValue.trim().toLowerCase();
  }


  @ViewChild(MatPaginator) paginator: MatPaginator;

  constructor(
    private aCategoriaSrv: ACategoriaService,
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

    
    this.aCategoriaSrv.actualizarFormulario(id, columna, this.editField)
  }

  ionViewWillEnter(){
    this.elements;
    this.contentEditable
  }


  getData() {
    this.aCategoriaSrv.getData().subscribe((formularioData: any) => {
      this.aCategoria = formularioData;
      this.aCategoria = new MatTableDataSource<aCategoria[]>(formularioData);
      this.aCategoria.paginator = this.paginator;
      console.log(this.aCategoria)
      formularioData.forEach(element =>{
        this.elements++;
      })
    });

   
  }

  goToAddCategoria(){
    this.router.navigateByUrl("add-categoria");
  }
  editar(){
    this.contentEditable = true;
    console.log(this.contentEditable)
  }

}
