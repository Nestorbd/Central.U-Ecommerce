import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { CliExistentePage } from './cli-existente.page';

const routes: Routes = [
  {
    path: '',
    component: CliExistentePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CliExistentePageRoutingModule {}
