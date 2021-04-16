import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AddColumnPageRoutingModule } from './add-column-routing.module';

import { AddColumnPage } from './add-column.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    AddColumnPageRoutingModule
  ],
  declarations: [AddColumnPage]
})
export class AddColumnPageModule {}
