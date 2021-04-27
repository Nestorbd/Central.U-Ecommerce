import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, tap } from 'rxjs/operators';
import { tTipo } from '../model/tTipo';

@Injectable({
  providedIn: 'root'
})
export class TTarifaService {
  apiUrl: string = "http://192.168.0.90/serigrafia/backend/api/";
  tipo: tTipo[];
  
  constructor(
    private httpClient: HttpClient
  ) { }


  getData(): Observable<tTipo[]> {

    return this.httpClient.get<tTipo[]>(this.apiUrl + "tipo")
    .pipe(
      
      tap(acategoria => console.log('Get a_categoria')),
      catchError(this.handleError('getFormulario', []))
    );
  }


  addCategoria(tipo: tTipo){
    console.log(tipo)
    this.httpClient.post(this.apiUrl + "tipo/insertar", tipo).subscribe(data => {
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
    this.httpClient.put(this.apiUrl + "tipo/actualizar/"+id, jsonVariable).subscribe(data => {
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
