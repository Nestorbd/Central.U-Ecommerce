import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { UploadImagePageRoutingModule } from './upload-image-routing.module';

import { UploadImagePage } from './upload-image.page';
import { HttpClientModule } from '@angular/common/http';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    HttpClientModule,
    UploadImagePageRoutingModule
  ],
  declarations: [UploadImagePage]
})
export class UploadImagePageModule {}
