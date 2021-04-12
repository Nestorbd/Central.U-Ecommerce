import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { NgxSelectoModule } from "ngx-selecto";
import { NgxMoveableModule } from "ngx-moveable";
import { IonicModule } from '@ionic/angular';

import { PruebasPageRoutingModule } from './pruebas-routing.module';

import { PruebasPage } from './pruebas.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    PruebasPageRoutingModule,
    NgxSelectoModule,
    NgxMoveableModule
  ],
  declarations: [PruebasPage]
})
export class PruebasPageModule {}
