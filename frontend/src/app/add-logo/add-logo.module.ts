import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AddLogoPageRoutingModule } from './add-logo-routing.module';

import { AddLogoPage } from './add-logo.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    IonicModule,
    AddLogoPageRoutingModule
  ],
  declarations: [AddLogoPage]
})
export class AddLogoPageModule {}
