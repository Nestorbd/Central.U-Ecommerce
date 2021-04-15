import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AddInputPage } from './add-input.page';

const routes: Routes = [
  {
    path: '',
    component: AddInputPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AddInputPageRoutingModule {}
