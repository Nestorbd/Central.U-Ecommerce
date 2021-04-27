import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AddTipoPageRoutingModule } from './add-tipo-routing.module';

import { AddTipoPage } from './add-tipo.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ReactiveFormsModule,
    MaterialModule,
    AddTipoPageRoutingModule
  ],
  declarations: [AddTipoPage]
})
export class AddTipoPageModule {}
