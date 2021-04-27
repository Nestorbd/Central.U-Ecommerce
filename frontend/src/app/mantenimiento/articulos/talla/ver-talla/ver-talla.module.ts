import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { VerTallaPageRoutingModule } from './ver-talla-routing.module';

import { VerTallaPage } from './ver-talla.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    
    VerTallaPageRoutingModule
  ],
  declarations: [VerTallaPage]
})
export class VerTallaPageModule {}
