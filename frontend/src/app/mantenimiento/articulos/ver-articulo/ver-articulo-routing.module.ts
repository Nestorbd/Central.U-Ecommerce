import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { VerArticuloPage } from './ver-articulo.page';

const routes: Routes = [
  {
    path: '',
    component: VerArticuloPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class VerArticuloPageRoutingModule {}
