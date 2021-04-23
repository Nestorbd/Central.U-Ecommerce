import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AddCategoriaPage } from './add-categoria.page';

const routes: Routes = [
  {
    path: '',
    component: AddCategoriaPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AddCategoriaPageRoutingModule {}
