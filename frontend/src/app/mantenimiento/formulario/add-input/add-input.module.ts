import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AddInputPageRoutingModule } from './add-input-routing.module';

import { AddInputPage } from './add-input.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ReactiveFormsModule,
    MaterialModule,
    AddInputPageRoutingModule
  ],
  declarations: [AddInputPage]
})
export class AddInputPageModule {}
