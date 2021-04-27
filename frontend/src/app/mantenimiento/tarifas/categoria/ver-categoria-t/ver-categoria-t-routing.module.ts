import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { VerCategoriaTPage } from './ver-categoria-t.page';

const routes: Routes = [
  {
    path: '',
    component: VerCategoriaTPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class VerCategoriaTPageRoutingModule {}
