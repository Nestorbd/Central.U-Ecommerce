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
    path: 'pruebas',
    loadChildren: () => import('./pruebas/pruebas.module').then( m => m.PruebasPageModule)
  },
  {
    path: 'form-page',
    loadChildren: () => import('./form-page/form-page.module').then( m => m.FormPagePageModule)
  },
  {
    path: 'pruebas-form',
    loadChildren: () => import('./pruebas-form/pruebas-form.module').then( m => m.PruebasFormPageModule)
  },
  {
    path: 'add-input',
    loadChildren: () => import('./mantenimiento/formulario/add-input/add-input.module').then( m => m.AddInputPageModule)
  },
  {
    path: 'add-column',
    loadChildren: () => import('./mantenimiento/formulario/add-column/add-column.module').then( m => m.AddColumnPageModule)
  },
  {
    path: 'mantenimiento-tablas',
    loadChildren: () => import('./mantenimiento/mantenimiento-tablas/mantenimiento-tablas.module').then( m => m.MantenimientoTablasPageModule)
  },
  {
    path: 'ver-input',
    loadChildren: () => import('./mantenimiento/formulario/ver-input/ver-input.module').then( m => m.VerInputPageModule)
  },
  {
    path: 'cli-existente',
    loadChildren: () => import('./modals/cli-existente/cli-existente.module').then( m => m.CliExistentePageModule)
  },
  {
    path: 'ver-cliente',
    loadChildren: () => import('./mantenimiento/cliente/ver-cliente/ver-cliente.module').then( m => m.VerClientePageModule)
  },
  {
    path: 'cliente-direccion',
    loadChildren: () => import('./mantenimiento/cliente/cliente-direccion/cliente-direccion.module').then( m => m.ClienteDireccionPageModule)
  },  {
    path: 'ver-categoria',
    loadChildren: () => import('./mantenimiento/articulos/categoria/ver-categoria/ver-categoria.module').then( m => m.VerCategoriaPageModule)
  },
  {
    path: 'articulos',
    loadChildren: () => import('./mantenimiento/articulos/articulos/articulos.module').then( m => m.ArticulosPageModule)
  },
  {
    path: 'add-categoria',
    loadChildren: () => import('./mantenimiento/articulos/categoria/add-categoria/add-categoria.module').then( m => m.AddCategoriaPageModule)
  },
  {
    path: 'boceto',
    loadChildren: () => import('./modals/boceto/boceto.module').then( m => m.BocetoPageModule)
  }






];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
