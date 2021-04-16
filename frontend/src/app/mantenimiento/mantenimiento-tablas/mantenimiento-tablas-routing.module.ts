import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { MantenimientoTablasPage } from './mantenimiento-tablas.page';

const routes: Routes = [
  {
    path: '',
    component: MantenimientoTablasPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class MantenimientoTablasPageRoutingModule {}
