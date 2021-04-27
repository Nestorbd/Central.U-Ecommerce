import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { VerTipoPage } from './ver-tipo.page';

const routes: Routes = [
  {
    path: '',
    component: VerTipoPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class VerTipoPageRoutingModule {}
