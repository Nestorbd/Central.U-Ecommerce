import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { VerColorPageRoutingModule } from './ver-color-routing.module';

import { VerColorPage } from './ver-color.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    VerColorPageRoutingModule
  ],
  declarations: [VerColorPage]
})
export class VerColorPageModule {}
