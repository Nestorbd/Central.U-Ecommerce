import { Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { Router } from '@angular/router';
import { tCategoria } from 'src/app/model/tCategoria';
import { CTarifaService } from 'src/app/services/t-categoria.service';

@Component({
  selector: 'app-ver-categoria-t',
  templateUrl: './ver-categoria-t.page.html',
  styleUrls: ['./ver-categoria-t.page.scss'],
})
export class VerCategoriaTPage implements OnInit {


  tCategoria;
  contentEditable: boolean = false;
  editField: string;
  elements : number = 0;
  displayedColumns: string[] = ['nombre','tipos','activo', 'editar'];
  

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.tCategoria.filter = filterValue.trim().toLowerCase();
  }


  @ViewChild(MatPaginator) paginator: MatPaginator;

  constructor(
    private cCategoriaSrv: CTarifaService,
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

    
    this.cCategoriaSrv.actualizarFormulario(id, columna, this.editField)
  }

  ionViewWillEnter(){
    this.elements;
    this.contentEditable
  }


  getData() {
    this.cCategoriaSrv.getData().subscribe((formularioData: any) => {
      this.tCategoria = formularioData;
      this.tCategoria = new MatTableDataSource<tCategoria[]>(formularioData);
      this.tCategoria.paginator = this.paginator;
      console.log(this.tCategoria)
      formularioData.forEach(element =>{
        this.elements++;
      })
    });

   
  }

  goToAddCategoria(){
    this.router.navigateByUrl("add-categoria-t");
  }
  editar(){
    this.contentEditable = true;
    console.log(this.contentEditable)
  }


}
