import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AddArticuloPageRoutingModule } from './add-articulo-routing.module';

import { AddArticuloPage } from './add-articulo.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    ReactiveFormsModule,
    AddArticuloPageRoutingModule
  ],
  declarations: [AddArticuloPage]
})
export class AddArticuloPageModule {}
