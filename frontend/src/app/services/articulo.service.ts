import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, tap } from 'rxjs/operators';
import { AddArticuloPage } from '../mantenimiento/articulos/add-articulo/add-articulo.page';
import { Articulo } from '../model/articulo';

@Injectable({
  providedIn: 'root'
})
export class ArticuloService {
  apiUrl: string = "http://192.168.0.90/serigrafia/backend/api/";
  id: number;
  imagen: string;
  constructor(
    private httpClient: HttpClient
  ) { }


  getId(){
    return this.id;
  }

  setId(id: number){
    this.id = id
  }

  getImagen(){
    return this.imagen
  }

  setImagen(imagen: string){
    this.imagen = imagen
  }
  
addArticulo(formdata: FormData){
  this.httpClient.post("http://192.168.0.90/serigrafia/backend/api/articulo/insertar", formdata).subscribe(data => {
    console.log(data)
  }, err => {
    console.log(err);
  });
}



getData(): Observable<Articulo[]> {

  return this.httpClient.get<Articulo[]>(this.apiUrl + "porDefecto")
  .pipe(
    
    tap(acategoria => console.log('Get a_categoria')),
    catchError(this.handleError('getFormulario', []))
  );
}




actualizarFormulario(id: number, columna:string, put:string){
  
  var jsonVariable = {};
  for(var i=1; i < 3; i++) {
    jsonVariable[columna] = put;        
  }
  this.httpClient.put(this.apiUrl + "articulo/actualizar/"+id, jsonVariable).subscribe(data => {
    console.log(data);
  }, err => {
    console.log(err);
  });
}


private handleError<T>(operation = 'operation', result ?: T){
  return (error: any): Observable<T> => {
    console.error(error);
    return of(result as T);
  };
}
}

