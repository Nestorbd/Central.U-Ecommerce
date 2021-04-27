import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AddCategoriaTPage } from './add-categoria-t.page';

const routes: Routes = [
  {
    path: '',
    component: AddCategoriaTPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AddCategoriaTPageRoutingModule {}
