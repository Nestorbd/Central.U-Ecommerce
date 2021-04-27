import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { VerTipoPageRoutingModule } from './ver-tipo-routing.module';

import { VerTipoPage } from './ver-tipo.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    VerTipoPageRoutingModule
  ],
  declarations: [VerTipoPage]
})
export class VerTipoPageModule {}
