import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { MantenimientoTablasPageRoutingModule } from './mantenimiento-tablas-routing.module';

import { MantenimientoTablasPage } from './mantenimiento-tablas.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    MantenimientoTablasPageRoutingModule
  ],
  declarations: [MantenimientoTablasPage]
})
export class MantenimientoTablasPageModule {}
