import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AddCategoriaTPageRoutingModule } from './add-categoria-t-routing.module';

import { AddCategoriaTPage } from './add-categoria-t.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule, 
    ReactiveFormsModule,
    AddCategoriaTPageRoutingModule
  ],
  declarations: [AddCategoriaTPage]
})
export class AddCategoriaTPageModule {}
