import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { VerArticuloPageRoutingModule } from './ver-articulo-routing.module';

import { VerArticuloPage } from './ver-articulo.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    VerArticuloPageRoutingModule
  ],
  declarations: [VerArticuloPage]
})
export class VerArticuloPageModule {}
