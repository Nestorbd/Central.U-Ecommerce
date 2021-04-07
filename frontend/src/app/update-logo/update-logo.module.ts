import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { UpdateLogoPageRoutingModule } from './update-logo-routing.module';

import { UpdateLogoPage } from './update-logo.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    IonicModule,
    UpdateLogoPageRoutingModule
  ],
  declarations: [UpdateLogoPage]
})
export class UpdateLogoPageModule {}
