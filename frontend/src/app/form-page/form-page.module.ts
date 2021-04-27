import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { NgxMoveableModule } from "ngx-moveable";
import { IonicModule } from '@ionic/angular';
import {IvyCarouselModule} from 'angular-responsive-carousel';


import { FormPagePage } from './form-page.page';
import { MaterialModule } from '../material.module';
import { FormPagePageRoutingModule } from './form-page-routing.module';
import { NgxSelectoModule } from 'ngx-selecto';
import { MatCarouselModule } from 'ng-mat-carousel';
@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MaterialModule,
    ReactiveFormsModule,
    NgxSelectoModule,
    NgxMoveableModule,
    IvyCarouselModule,
    MatCarouselModule.forRoot(),
    FormPagePageRoutingModule
  ],
  declarations: [FormPagePage]
})
export class FormPagePageModule {}
