import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { UpdateLogoPage } from './update-logo.page';

const routes: Routes = [
  {
    path: '',
    component: UpdateLogoPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class UpdateLogoPageRoutingModule {}
