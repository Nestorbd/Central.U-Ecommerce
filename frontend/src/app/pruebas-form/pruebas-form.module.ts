import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { PruebasFormPageRoutingModule } from './pruebas-form-routing.module';

import { PruebasFormPage } from './pruebas-form.page';
import { MaterialModule } from '../material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ReactiveFormsModule,
    MaterialModule,
    PruebasFormPageRoutingModule
  ],
  declarations: [PruebasFormPage]
})
export class PruebasFormPageModule {}
