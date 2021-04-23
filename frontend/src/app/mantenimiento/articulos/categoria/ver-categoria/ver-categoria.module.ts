import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { VerCategoriaPageRoutingModule } from './ver-categoria-routing.module';

import { VerCategoriaPage } from './ver-categoria.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    VerCategoriaPageRoutingModule
  ],
  declarations: [VerCategoriaPage]
})
export class VerCategoriaPageModule {}
