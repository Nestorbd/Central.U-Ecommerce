import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {  FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ClienteDireccionPageRoutingModule } from './cliente-direccion-routing.module';

import { ClienteDireccionPage } from './cliente-direccion.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    ReactiveFormsModule,
    ClienteDireccionPageRoutingModule
  ],
  declarations: [ClienteDireccionPage]
})
export class ClienteDireccionPageModule {}
