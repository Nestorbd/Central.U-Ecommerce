import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, tap } from 'rxjs/operators';
import { Formulario } from '../model/formulario';

@Injectable({
  providedIn: 'root'
})
export class FormularioService {

  constructor(
    private httpClient: HttpClient
    ) { }


  getData(): Observable<Formulario[]> {

    return this.httpClient.get<Formulario[]>("http://192.168.0.90/serigrafia/backend/api/formulario")
    .pipe(
      
      tap(logotipos => console.log('Get Formulario')),
      catchError(this.handleError('getFormulario', []))
    );
  }


  addFormulario(formulario: Formulario){
    console.log(formulario)
    this.httpClient.post("http://192.168.0.90/serigrafia/backend/api/formulario/insertar", formulario).subscribe(data => {
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
    this.httpClient.put("http://192.168.0.90/serigrafia/backend/api/formulario/actualizar/"+id, jsonVariable).subscribe(data => {
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
