import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { Logotipo } from '../model/logotipo';
import { catchError, tap } from 'rxjs/operators';


@Injectable({
  providedIn: 'root'
})
export class LogotipoService {

  currentId: number
  logotipos: Logotipo[]
  constructor(
    private httpClient: HttpClient
  ) { }


  getLogos(): Observable<Logotipo[]> {

    return this.httpClient.get<Logotipo[]>("http://localhost/crud_api/api/logotipos/")
    .pipe(
      
      tap(logotipos => console.log('Get logotipos')),
      catchError(this.handleError('getTask', []))
    );
  }


  getLogoById(id: number) {
   
    return this.httpClient.get("http://localhost:80/crud_api/api/logotipo/"+ id).pipe(
        tap(data => {
          console.log(data);
        }, err => {
          console.log(err);
        }));
  }



  updateLogo(id: number, logotipo: Logotipo) {

    this.httpClient.put("http://localhost:80/crud_api/api/actualizarLogotipo/" + id,
      { 'nombre': logotipo.nombre
      }).subscribe(data => {
        console.log(data);
      }, err => {
        console.log(err);
      });

  }

  addLogo( formData: FormData) {


    this.httpClient.post("http://localhost:80/api/logotipo/insertar", formData).subscribe(data => {
        console.log(data);
      }, err => {
        console.log(err);
      });

  }

  deleteLogo(id: number, ){
    this.httpClient.delete("http://localhost:80/crud_api/api/eliminarLogotipo/" + id ).subscribe(data => {
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
