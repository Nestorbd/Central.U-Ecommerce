import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ClienteDireccionPage } from './cliente-direccion.page';

const routes: Routes = [
  {
    path: '',
    component: ClienteDireccionPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ClienteDireccionPageRoutingModule {}
