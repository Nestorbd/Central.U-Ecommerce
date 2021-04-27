import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AddTipoPage } from './add-tipo.page';

const routes: Routes = [
  {
    path: '',
    component: AddTipoPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AddTipoPageRoutingModule {}
