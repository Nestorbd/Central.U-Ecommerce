import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AddLogoPageRoutingModule } from './add-logo-routing.module';

import { AddLogoPage } from './add-logo.page';
import { MaterialModule } from '../material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    IonicModule,
    MaterialModule,
    AddLogoPageRoutingModule
  ],
  declarations: [AddLogoPage]
})
export class AddLogoPageModule {}
