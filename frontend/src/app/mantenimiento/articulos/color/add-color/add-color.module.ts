import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AddColorPageRoutingModule } from './add-color-routing.module';

import { AddColorPage } from './add-color.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ReactiveFormsModule,
    AddColorPageRoutingModule
  ],
  declarations: [AddColorPage]
})
export class AddColorPageModule {}
