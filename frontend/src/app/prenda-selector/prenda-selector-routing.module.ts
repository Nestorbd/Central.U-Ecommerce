import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { PrendaSelectorPage } from './prenda-selector.page';

const routes: Routes = [
  {
    path: '',
    component: PrendaSelectorPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PrendaSelectorPageRoutingModule {}
