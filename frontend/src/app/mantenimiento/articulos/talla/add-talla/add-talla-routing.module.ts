import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AddTallaPage } from './add-talla.page';

const routes: Routes = [
  {
    path: '',
    component: AddTallaPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AddTallaPageRoutingModule {}
