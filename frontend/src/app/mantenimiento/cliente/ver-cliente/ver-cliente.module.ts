import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { VerClientePageRoutingModule } from './ver-cliente-routing.module';

import { VerClientePage } from './ver-cliente.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    VerClientePageRoutingModule
  ],
  declarations: [VerClientePage]
})
export class VerClientePageModule {}
