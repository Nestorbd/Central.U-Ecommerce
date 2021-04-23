import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { BocetoPageRoutingModule } from './boceto-routing.module';

import { BocetoPage } from './boceto.page';
import { NgxSelectoModule } from 'ngx-selecto';
import { NgxMoveableModule } from "ngx-moveable";
@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    BocetoPageRoutingModule,
    NgxSelectoModule,
    NgxMoveableModule
  ],
  declarations: [BocetoPage]
})
export class BocetoPageModule {}
