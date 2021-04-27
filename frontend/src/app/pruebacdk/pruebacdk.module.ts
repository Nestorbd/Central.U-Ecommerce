import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { PruebacdkPageRoutingModule } from './pruebacdk-routing.module';

import { PruebacdkPage } from './pruebacdk.page';
import { MaterialModule } from '../material.module';
import { NgxSelectoModule } from 'ngx-selecto';
import { NgxMoveableModule } from "ngx-moveable";

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    NgxSelectoModule,
    NgxMoveableModule,
    PruebacdkPageRoutingModule
  ],
  declarations: [PruebacdkPage]
})
export class PruebacdkPageModule {}
