import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { NgxMoveableModule } from "ngx-moveable";
import { IonicModule } from '@ionic/angular';



import { FormPagePage } from './form-page.page';
import { MaterialModule } from '../material.module';
import { FormPagePageRoutingModule } from './form-page-routing.module';
import { NgxSelectoModule } from 'ngx-selecto';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    ReactiveFormsModule,
    NgxSelectoModule,
    NgxMoveableModule,
    FormPagePageRoutingModule
  ],
  declarations: [FormPagePage]
})
export class FormPagePageModule {}
