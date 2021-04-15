import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { VerInputPage } from './ver-input.page';

const routes: Routes = [
  {
    path: '',
    component: VerInputPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class VerInputPageRoutingModule {}
