import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AddCategoriaPageRoutingModule } from './add-categoria-routing.module';

import { AddCategoriaPage } from './add-categoria.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ReactiveFormsModule,
    AddCategoriaPageRoutingModule
  ],
  declarations: [AddCategoriaPage]
})
export class AddCategoriaPageModule {}
