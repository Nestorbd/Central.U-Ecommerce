import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { VerTarifasPageRoutingModule } from './ver-tarifas-routing.module';

import { VerTarifasPage } from './ver-tarifas.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    VerTarifasPageRoutingModule
  ],
  declarations: [VerTarifasPage]
})
export class VerTarifasPageModule {}
