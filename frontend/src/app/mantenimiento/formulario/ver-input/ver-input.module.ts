import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { VerInputPageRoutingModule } from './ver-input-routing.module';

import { VerInputPage } from './ver-input.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    VerInputPageRoutingModule
  ],
  declarations: [VerInputPage]
})
export class VerInputPageModule {}
