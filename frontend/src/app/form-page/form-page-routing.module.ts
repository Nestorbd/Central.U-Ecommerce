import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { FormPagePage } from './form-page.page';

const routes: Routes = [
  {
    path: '',
    component: FormPagePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class FormPagePageRoutingModule {}
