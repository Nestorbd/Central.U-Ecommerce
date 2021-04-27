import { Component, OnInit, ViewChild } from "@angular/core";
import {
  animate,
  state,
  style,
  transition,
  trigger
} from "@angular/animations";
import { ArticuloService } from "../services/articulo.service";
import { MatTableDataSource } from "@angular/material/table";
import { Articulo } from "../model/articulo";
import { aTalla } from "../model/aTalla";
import { MatPaginator } from "@angular/material/paginator";
@Component({
  selector: 'app-pruebas-form',
  templateUrl: './pruebas-form.page.html',
  styleUrls: ['./pruebas-form.page.scss'],
  animations: [
    trigger("detailExpand", [
      state(
        "collapsed",
        style({ height: "0px", minHeight: "0", display: "none" })
      ),
      state("expanded", style({ height: "*" })),
      transition(
        "expanded <=> collapsed",
        animate("225ms cubic-bezier(0.4, 0.0, 0.2, 1)")
      )
    ])
  ],
})

export class PruebasFormPage implements OnInit {
  aTalla;
  elements : number = 0;
  columnsToDisplay : string[] = ['nombre', 'tallas','colores', 'codigo_barra', 'stock', 'activo' ]
  expandedElement: aTalla | null;

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.aTalla.filter = filterValue.trim().toLowerCase();
  }


  @ViewChild(MatPaginator) paginator: MatPaginator;

  constructor(
    private articuloSrv: ArticuloService
  ){}
  
  ngOnInit(){
    this.getData();
  }

  getData() {
    
    this.articuloSrv.getData().subscribe((formularioData: any) => {
      console.log(formularioData)
      formularioData.forEach(element => {
        console.log(element.tallas)
      });
      this.aTalla = formularioData;
      this.aTalla = new MatTableDataSource<Articulo[]>(formularioData);
      this.aTalla.paginator = this.paginator;
      console.log(this.aTalla)
      formularioData.forEach(element =>{
        this.elements++;
      })
    });

   
  }
}

