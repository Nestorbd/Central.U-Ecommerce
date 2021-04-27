import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, tap } from 'rxjs/operators';
import { tCategoria } from '../model/tCategoria';

@Injectable({
  providedIn: 'root'
})
export class CTarifaService {
  apiUrl: string = "http://192.168.0.90/serigrafia/backend/api/";
  categoria: tCategoria[];
  
  constructor(
    private httpClient: HttpClient
  ) { }


  getData(): Observable<tCategoria[]> {

    return this.httpClient.get<tCategoria[]>(this.apiUrl + "categoriaTarifa")
    .pipe(
      
      tap(acategoria => console.log(acategoria)),
      catchError(this.handleError('getFormulario', []))
    );
  }


  addCategoria(categoria: tCategoria){
    console.log(categoria)
    this.httpClient.post(this.apiUrl + "categoriaTarifa/insertar", categoria).subscribe(data => {
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
    this.httpClient.put(this.apiUrl + "categoriaTarifa/actualizar/"+id, jsonVariable).subscribe(data => {
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
