import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, tap } from 'rxjs/operators';
import { aTalla } from '../model/aTalla';

@Injectable({
  providedIn: 'root'
})
export class ATallaService {
  apiUrl: string = "http://192.168.0.90/serigrafia/backend/api/";
  talla: aTalla[];
  
  constructor(
    private httpClient: HttpClient
  ) { }


  getData(): Observable<aTalla[]> {

    return this.httpClient.get<aTalla[]>(this.apiUrl + "talla")
    .pipe(
      
      tap(acategoria => console.log('Get a_categoria')),
      catchError(this.handleError('getFormulario', []))
    );
  }


  addCategoria(talla: aTalla){
    console.log(talla)
    this.httpClient.post(this.apiUrl + "talla/insertar", talla).subscribe(data => {
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
    this.httpClient.put(this.apiUrl + "talla/actualizar/"+id, jsonVariable).subscribe(data => {
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
