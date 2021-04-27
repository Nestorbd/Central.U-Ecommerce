import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { resolve } from 'node:path';
import { Observable, of } from 'rxjs';
import { catchError, tap } from 'rxjs/operators';
import { Cliente } from '../model/cliente';
import { Cliente_Empresa } from '../model/cliente_empresa';
import { Cliente_Individual } from '../model/cliente_individual';
import { Direccion } from '../model/direccion';

@Injectable({
  providedIn: 'root'
})
export class ClienteService {
apiUrl: string = "http://192.168.0.90/serigrafia/backend/api/";
isId: boolean = false;
cliente: Cliente_Individual[];
idIndividual: number = 1;
idEmpresa: number;

  constructor(
    private httpClient: HttpClient
    ) { }


  getData(): Observable<Cliente[]> {

    return this.httpClient.get<Cliente[]>(this.apiUrl + "cliente")
    .pipe(
      
      tap(logotipos => console.log('Get Formulario')),
      catchError(this.handleError('getFormulario', []))
    );
  }


  // getDireccionByUserId(id:number, tf: boolean): Observable<Direccion[]> {
  
  //   return this.httpClient.get<Direccion[]>("http://localhost/api/direccion/cliente/"+id+"?es_empresa="+tf)
  //   .pipe(
      
  //     tap(direccion => console.log('Get direccion')),
  //     catchError(this.handleError('getDireccion', []))
  //   );
  // }



  getIndividualId(){
    return this.idIndividual
  }

  setIndividualId(id: number){
    console.log(id)
    this.idIndividual = id
  }
  
  getEmpresaId(){
    return this.idEmpresa
  }

  setEmpresaId(id: number){
    console.log(id)
    this.idEmpresa = id
  }




  addIndividual(cliente: Cliente_Individual){
    console.log(cliente)
   return new Promise((resolve, reject)=> { 
    
        this.httpClient.post(this.apiUrl + "cliente/insertar", cliente).subscribe(data => {
          console.log(data[0].id_individual)
        resolve(
          this.setIndividualId(data[0].id_individual)
          )
      }, err => {
        console.log(err);
      })

    });
  }

  updateIndividual(id: number, cliente: Cliente_Individual) {

    this.httpClient.put(this.apiUrl + "cliente/actualizar/" + id,
     
      cliente).subscribe(data => {
        console.log(data);
      }, err => {
        console.log(err);
      });
  }


  
  updateEmpresa(id: number, cliente: Cliente_Empresa) {

    this.httpClient.put(this.apiUrl + "cliente/actualizar/" + id,
     
      cliente).subscribe(data => {
        console.log(data);
      }, err => {
        console.log(err);
      });
  }


  addEmpresa(cliente: Cliente_Empresa){
    return new Promise((resolve, reject)=> { 
    
      this.httpClient.post(this.apiUrl + "cliente/insertar", cliente).subscribe(data => {
        
      resolve(this.setEmpresaId(data[0].id_empresa))
    }, err => {
      console.log(err);
    })

  });
  }


  getClienteByID(id: number, tf: boolean): Observable<Cliente>{
    return this.httpClient.get<Cliente>(this.apiUrl + "cliente/ver/"+id+"?es_empresa="+tf)

  }

  addDireccion(direccion: Direccion){
    console.log(direccion)
    this.httpClient.post(this.apiUrl + "direccion/insertar", direccion).subscribe(data => {
      console.log(data)
      this.isId = false;
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
