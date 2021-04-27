import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AddTallaPageRoutingModule } from './add-talla-routing.module';

import { AddTallaPage } from './add-talla.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ReactiveFormsModule,
    AddTallaPageRoutingModule
  ],
  declarations: [AddTallaPage]
})
export class AddTallaPageModule {}
