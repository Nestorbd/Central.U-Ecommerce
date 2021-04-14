import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';



import { FormPagePage } from './form-page.page';
import { MaterialModule } from '../material.module';
import { FormPagePageRoutingModule } from './form-page-routing.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    ReactiveFormsModule,
    FormPagePageRoutingModule
  ],
  declarations: [FormPagePage]
})
export class FormPagePageModule {}
