import { Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { Router } from '@angular/router';
import { aTalla } from 'src/app/model/aTalla';
import { AColorService } from 'src/app/services/a-color.service';
import { ATallaService } from 'src/app/services/a-talla.service';

@Component({
  selector: 'app-ver-color',
  templateUrl: './ver-color.page.html',
  styleUrls: ['./ver-color.page.scss'],
})
export class VerColorPage implements OnInit {

  aColor;
  contentEditable: boolean = false;
  editField: string;
  elements : number = 0;
  displayedColumns: string[] = ['nombre', 'activo', 'editar'];
  

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.aColor.filter = filterValue.trim().toLowerCase();
  }


  @ViewChild(MatPaginator) paginator: MatPaginator;

  constructor(
    private aColorSrv: AColorService,
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

    
    this.aColorSrv.actualizarFormulario(id, columna, this.editField)
  }

  ionViewWillEnter(){
    this.elements;
    this.contentEditable
  }


  getData() {
    this.aColorSrv.getData().subscribe((formularioData: any) => {
      this.aColor = formularioData;
      this.aColor = new MatTableDataSource<aTalla[]>(formularioData);
      this.aColor.paginator = this.paginator;
      console.log(this.aColor)
      formularioData.forEach(element =>{
        this.elements++;
      })
    });

   
  }

  goToAddColor(){
    this.router.navigateByUrl("add-color");
  }
  editar(){
    this.contentEditable = true;
    console.log(this.contentEditable)
  }


}
