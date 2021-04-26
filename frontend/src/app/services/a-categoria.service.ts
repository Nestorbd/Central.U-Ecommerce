import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, tap } from 'rxjs/operators';
import { aCategoria } from '../model/aCategoria';

@Injectable({
  providedIn: 'root'
})
export class ACategoriaService {

  apiUrl: string = "http://192.168.0.90/serigrafia/backend/api/";
  categoria: aCategoria[];
  
  constructor(
    private httpClient: HttpClient
  ) { }


  getData(): Observable<aCategoria[]> {

    return this.httpClient.get<aCategoria[]>(this.apiUrl + "categoriaArticulo")
    .pipe(
      
      tap(acategoria => console.log('Get a_categoria')),
      catchError(this.handleError('getFormulario', []))
    );
  }


  addCategoria(categoria: aCategoria){
    console.log(categoria)
    this.httpClient.post(this.apiUrl + "categoriaArticulo/insertar", categoria).subscribe(data => {
      console.log(data);
    }, err => {
      console.log(err);
    });
  }

  actualizarFormulario(id: number, columna:string, put:string){
    
    var jsonVariable = {};
    for(var i=1; i < 3; i++) {
      jsonVariable[columna] = put;        
    }
    this.httpClient.put(this.apiUrl + "categoriaArticulo/actualizar/"+id, jsonVariable).subscribe(data => {
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
