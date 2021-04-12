import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-upload-image',
  templateUrl: './upload-image.page.html',
  styleUrls: ['./upload-image.page.scss'],
})
export class UploadImagePage {

  image: any;
  constructor( private http: HttpClient) { }

  selectedFile(event){
    this.image = event.target.files[0];
  }

  onClick(){
    const formData = new FormData();
    formData.append('imagen', this.image)
  }

}
