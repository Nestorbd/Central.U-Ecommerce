import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, tap } from 'rxjs/operators';
import { Direccion } from '../model/direccion';

@Injectable({
  providedIn: 'root'
})
export class DireccionService {
  id: number;
  tf: boolean;
  direccion: Direccion[];

  constructor(
    private httpClient: HttpClient
  ) { }


  
  getId(){
    return this.id
  }

  setTf(tf: boolean){
    console.log(tf)
    this.tf = tf
  }
  
  getTf(){
    return this.tf
  }

  setId(id: number){
    console.log(id)
    this.id = id
  }


  getDireccionByUserId(id:number, tf: boolean): Observable<Direccion[]> {
  
    return this.httpClient.get<Direccion[]>("http://192.168.0.90/serigrafia/backend/api/direccion/cliente/"+id+"?es_empresa="+tf)
    .pipe(
      
      tap(direccion => console.log('Get direccion')),
      catchError(this.handleError('getDireccion', []))
    );
  }


  
  actualizarDireccion(id: number, columna:string, put:string){
    
    var jsonVariable = {};
    for(var i=1; i < 3; i++) {
      jsonVariable[columna] = put;        
    }
    this.httpClient.put("http://192.168.0.90/serigrafia/backend/api/direccion/actualizar/"+id, jsonVariable).subscribe(data => {
      console.log(data);
    }, err => {
      console.log(err);
    });
  }

  eliminarDireccionById(id: number){
    
    this.httpClient.delete("http://192.168.0.90/serigrafia/backend/api/direccion/eliminar/"+id).subscribe(data => {
      console.log(data);
    }, err =>{
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
