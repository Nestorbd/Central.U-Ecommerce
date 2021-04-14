import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { PruebasFormPage } from './pruebas-form.page';

const routes: Routes = [
  {
    path: '',
    component: PruebasFormPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PruebasFormPageRoutingModule {}
