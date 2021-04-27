import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { VerTallaPage } from './ver-talla.page';

const routes: Routes = [
  {
    path: '',
    component: VerTallaPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class VerTallaPageRoutingModule {}
