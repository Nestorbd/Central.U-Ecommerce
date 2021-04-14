import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { PrendaSelectorPageRoutingModule } from './prenda-selector-routing.module';

import { PrendaSelectorPage } from './prenda-selector.page';
import { MaterialModule } from '../material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    PrendaSelectorPageRoutingModule
  ],
  declarations: [PrendaSelectorPage]
})
export class PrendaSelectorPageModule {}
