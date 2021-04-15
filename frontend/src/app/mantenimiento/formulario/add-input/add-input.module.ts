import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AddInputPageRoutingModule } from './add-input-routing.module';

import { AddInputPage } from './add-input.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    AddInputPageRoutingModule
  ],
  declarations: [AddInputPage]
})
export class AddInputPageModule {}
