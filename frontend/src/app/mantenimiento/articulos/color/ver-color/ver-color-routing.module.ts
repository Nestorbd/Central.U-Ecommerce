import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { VerColorPage } from './ver-color.page';

const routes: Routes = [
  {
    path: '',
    component: VerColorPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class VerColorPageRoutingModule {}
