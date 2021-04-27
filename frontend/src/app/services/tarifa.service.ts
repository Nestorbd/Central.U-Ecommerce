import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, tap } from 'rxjs/operators';
import { Tarifa } from '../model/tarifa';

@Injectable({
  providedIn: 'root'
})
export class TarifaService {

  apiUrl: string = "http://192.168.0.90/serigrafia/backend/api/";
  tarifa: Tarifa[];
  
  constructor(
    private httpClient: HttpClient
  ) { }


  getData(): Observable<Tarifa[]> {

    return this.httpClient.get<Tarifa[]>(this.apiUrl + "tarifa")
    .pipe(
      
      tap(acategoria => console.log('Get a_categoria')),
      catchError(this.handleError('getFormulario', []))
    );
  }


  addCategoria(tarifa: Tarifa){
    console.log(tarifa)
    this.httpClient.post(this.apiUrl + "tarifa/insertar", tarifa).subscribe(data => {
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
    this.httpClient.put(this.apiUrl + "tarifa/actualizar/"+id, jsonVariable).subscribe(data => {
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
