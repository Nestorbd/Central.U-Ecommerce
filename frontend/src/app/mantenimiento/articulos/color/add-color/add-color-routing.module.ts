import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AddColorPage } from './add-color.page';

const routes: Routes = [
  {
    path: '',
    component: AddColorPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AddColorPageRoutingModule {}
