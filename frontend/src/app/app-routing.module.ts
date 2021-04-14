import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: 'home',
    loadChildren: () => import('./home/home.module').then( m => m.HomePageModule)
  },
  {
    path: '',
    redirectTo: 'home',
    pathMatch: 'full'
  },
  {
    path: 'add-logo',
    loadChildren: () => import('./mantenimiento/logo/add-logo/add-logo.module').then( m => m.AddLogoPageModule)
  },
  {
    path: 'update-logo',
    loadChildren: () => import('./mantenimiento/logo/update-logo/update-logo.module').then( m => m.UpdateLogoPageModule)
  },
  {
    path: 'pruebas',
    loadChildren: () => import('./pruebas/pruebas.module').then( m => m.PruebasPageModule)
  },  {
    path: 'prenda-selector',
    loadChildren: () => import('./prenda-selector/prenda-selector.module').then( m => m.PrendaSelectorPageModule)
  },
  {
    path: 'form-page',
    loadChildren: () => import('./form-page/form-page.module').then( m => m.FormPagePageModule)
  },
  {
    path: 'pruebas-form',
    loadChildren: () => import('./pruebas-form/pruebas-form.module').then( m => m.PruebasFormPageModule)
  }



];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
