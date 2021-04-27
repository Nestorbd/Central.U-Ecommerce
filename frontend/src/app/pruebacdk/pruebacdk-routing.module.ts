import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { PruebacdkPage } from './pruebacdk.page';

const routes: Routes = [
  {
    path: '',
    component: PruebacdkPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PruebacdkPageRoutingModule {}
