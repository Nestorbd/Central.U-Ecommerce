import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { Logotipo } from '../model/logotipo';
import { catchError, tap } from 'rxjs/operators';


@Injectable({
  providedIn: 'root'
})
export class LogotipoService {
  apiUrl: string = "http://192.168.0.90/serigrafia/backend/api/";
  id: number;
  imagen: string;

  currentId: number
  logotipos: Logotipo[]
  constructor(
    private httpClient: HttpClient
  ) { }



  setIdLogo(id: number){
    this.id = id;
  }

  setImagenLogo(imagen: string){
    this.imagen = imagen
  }

  getIdLogo(){
    return this.id
  }
  getIdImagen(){
    return this.imagen
  }


  getLogos(): Observable<Logotipo[]> {

    return this.httpClient.get<Logotipo[]>(this.apiUrl + "logotipo")
    .pipe(
      
      tap(logotipos => console.log('Get logotipos')),
      catchError(this.handleError('getTask', []))
    );
  }


  getLogoById(id: number) {
   
    return this.httpClient.get(this.apiUrl + "logotipo/ver/"+ id).pipe(
        tap(data => {
        
        }, err => {
          console.log(err);
        }));
  }


  getLogoByClientId(id: number, tf: boolean) {
    console.log(id, tf)
    return this.httpClient.get(this.apiUrl + "logotipo/cliente/"+ id+"?es_empresa="+tf).pipe(
        tap(data => {
          console.log(data);
        }, err => {
          console.log(err);
        }));
  }


  updateLogo(id: number, nombre: string) {

    this.httpClient.put(this.apiUrl + "logotipo/actualizar/" + id,
      { 'nombre': nombre
      }).subscribe(data => {
        console.log(data);
      }, err => {
        console.log(err);
      });

  }


  updateLogoToSetIndividual(id: number, id_individual: number) {

    this.httpClient.put(this.apiUrl + "logotipo/actualizar/" + id,
      { 'id_individual': id_individual
      }).subscribe(data => {
        console.log(data);
      }, err => {
        console.log(err);
      });

  }

  updateLogoToSetBusiness(id: number, id_empresa: number) {

    this.httpClient.put("logotipo/actualizar/" + id,
      { 'id_empresa': id_empresa
      }).subscribe(data => {
        console.log(data);
      }, err => {
        console.log(err);
      });

  }


  addLogo( formData: FormData) {

return new Promise((resolve, reject) =>{
  this.httpClient.post(this.apiUrl + "logotipo/insertar", formData).subscribe(data => {
    resolve(this.setIdLogo(data[0].id) )
    resolve(this.setImagenLogo(data[0].imagen_png));
  }, err => {
    console.log(err);
  });
})


  }

  deleteLogo(id: number, ){
    this.httpClient.delete(this.apiUrl + "eliminarLogotipo/" + id ).subscribe(data => {
      console.log(data);
    }, err =>{
      console.log(err);
    });
  }

  setCurrentLogoId(id: number){
    this.currentId = id
  }

  getCurrentLogoId(){
    return this.currentId
  }

  
  private handleError<T>(operation = 'operation', result ?: T){
    return (error: any): Observable<T> => {
      console.error(error);
      return of(result as T);
    };
  }
  
}
