import { Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { Router } from '@angular/router';
import { aTalla } from 'src/app/model/aTalla';
import { ATallaService } from 'src/app/services/a-talla.service';

@Component({
  selector: 'app-ver-talla',
  templateUrl: './ver-talla.page.html',
  styleUrls: ['./ver-talla.page.scss'],
})
export class VerTallaPage implements OnInit {


  aTalla;
  contentEditable: boolean = false;
  editField: string;
  elements : number = 0;
  displayedColumns: string[] = ['nombre', 'activo', 'editar'];
  

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.aTalla.filter = filterValue.trim().toLowerCase();
  }


  @ViewChild(MatPaginator) paginator: MatPaginator;

  constructor(
    private aTallaSrv: ATallaService,
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

    
    this.aTallaSrv.actualizarFormulario(id, columna, this.editField)
  }

  ionViewWillEnter(){
    this.elements;
    this.contentEditable
  }


  getData() {
    
    this.aTallaSrv.getData().subscribe((formularioData: any) => {
      console.log(formularioData)
      this.aTalla = formularioData;
      this.aTalla = new MatTableDataSource<aTalla[]>(formularioData);
      this.aTalla.paginator = this.paginator;
      console.log(this.aTalla)
      formularioData.forEach(element =>{
        this.elements++;
      })
    });

   
  }

  goToAddTalla(){
    this.router.navigateByUrl("add-talla");
  }
  editar(){
    this.contentEditable = true;
    console.log(this.contentEditable)
  }

}
