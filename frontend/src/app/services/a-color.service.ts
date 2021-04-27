import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, tap } from 'rxjs/operators';
import { aColor } from '../model/aColor';

@Injectable({
  providedIn: 'root'
})
export class AColorService {

  apiUrl: string = "http://192.168.0.90/serigrafia/backend/api/";
  color: aColor[];
  
  constructor(
    private httpClient: HttpClient
  ) { }


  getData(): Observable<aColor[]> {

    return this.httpClient.get<aColor[]>(this.apiUrl + "color")
    .pipe(
      
      tap(acategoria => console.log('Get a_categoria')),
      catchError(this.handleError('getFormulario', []))
    );
  }


  addCategoria(color: aColor){
    console.log(color)
    this.httpClient.post(this.apiUrl + "color/insertar", color).subscribe(data => {
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
    this.httpClient.put(this.apiUrl + "color/actualizar/"+id, jsonVariable).subscribe(data => {
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
