import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { NgxSelectoModule } from "ngx-selecto";
import { NgxMoveableModule } from "ngx-moveable";
import { IonicModule } from '@ionic/angular';

import { PruebasFormPageRoutingModule } from './pruebas-form-routing.module';

import { PruebasFormPage } from './pruebas-form.page';
import { MaterialModule } from '../material.module';
import { MatCarouselModule } from 'ng-mat-carousel';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ReactiveFormsModule,
    MaterialModule,
    NgxSelectoModule,
    NgxMoveableModule,
    MatCarouselModule.forRoot(),
    PruebasFormPageRoutingModule
  ],
  declarations: [PruebasFormPage]
})
export class PruebasFormPageModule {}
