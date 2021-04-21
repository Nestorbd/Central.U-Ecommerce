import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ClienteDireccionPageRoutingModule } from './cliente-direccion-routing.module';

import { ClienteDireccionPage } from './cliente-direccion.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ClienteDireccionPageRoutingModule
  ],
  declarations: [ClienteDireccionPage]
})
export class ClienteDireccionPageModule {}
