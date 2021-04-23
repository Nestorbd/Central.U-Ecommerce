import { Component, OnInit, ViewChild } from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { Router } from '@angular/router';
import { element } from 'protractor';
import { Formulario } from 'src/app/model/formulario';
import { FormularioService } from 'src/app/services/formulario.service';


@Component({
  selector: 'app-ver-input',
  templateUrl: './ver-input.page.html',
  styleUrls: ['./ver-input.page.scss'],
})
export class VerInputPage implements OnInit {
  formulario;
  contentEditable: boolean = false;
  editField: string;
  elements : number = 0;
  displayedColumns: string[] = ['apartado', 'label', 'tipo', 'formControlName', 'placeholder', 'value' , 'activo', 'editar'];
  

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.formulario.filter = filterValue.trim().toLowerCase();
  }


  @ViewChild(MatPaginator) paginator: MatPaginator;

  constructor(
    private frmService: FormularioService,
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

    
    this.frmService.actualizarFormulario(id, columna, this.editField)
  }

  ionViewWillEnter(){
    this.elements;
    this.contentEditable
  }


  getData() {
    this.frmService.getData().subscribe((formularioData: any) => {
      this.formulario = formularioData;
      this.formulario = new MatTableDataSource<Formulario[]>(formularioData);
      this.formulario.paginator = this.paginator;
      console.log(this.formulario)
      formularioData.forEach(element =>{
        this.elements++;
      })
    });

   
  }

  goToAddInput(){
    this.router.navigateByUrl("add-input");
  }

  editar(){
    this.contentEditable = true;
    console.log(this.contentEditable)
  }
}
