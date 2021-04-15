import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AddColumnPage } from './add-column.page';

const routes: Routes = [
  {
    path: '',
    component: AddColumnPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AddColumnPageRoutingModule {}
