import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { VerCategoriaTPageRoutingModule } from './ver-categoria-t-routing.module';

import { VerCategoriaTPage } from './ver-categoria-t.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    VerCategoriaTPageRoutingModule
  ],
  declarations: [VerCategoriaTPage]
})
export class VerCategoriaTPageModule {}
