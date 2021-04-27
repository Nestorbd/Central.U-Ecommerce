import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { BocetoPage } from './boceto.page';

const routes: Routes = [
  {
    path: '',
    component: BocetoPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class BocetoPageRoutingModule {}
