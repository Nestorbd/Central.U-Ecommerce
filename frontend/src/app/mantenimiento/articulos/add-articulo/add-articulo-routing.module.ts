import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AddArticuloPage } from './add-articulo.page';

const routes: Routes = [
  {
    path: '',
    component: AddArticuloPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AddArticuloPageRoutingModule {}
