import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { VerCategoriaPage } from './ver-categoria.page';

const routes: Routes = [
  {
    path: '',
    component: VerCategoriaPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class VerCategoriaPageRoutingModule {}
