import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { CliExistentePageRoutingModule } from './cli-existente-routing.module';

import { CliExistentePage } from './cli-existente.page';
import { MaterialModule } from 'src/app/material.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    CliExistentePageRoutingModule
  ],
  declarations: [CliExistentePage]
})
export class CliExistentePageModule {}
