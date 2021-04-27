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
  },
  {
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
  },
  {
    path: 'ver-talla',
    loadChildren: () => import('./mantenimiento/articulos/talla/ver-talla/ver-talla.module').then( m => m.VerTallaPageModule)
  },
  {
    path: 'add-talla',
    loadChildren: () => import('./mantenimiento/articulos/talla/add-talla/add-talla.module').then( m => m.AddTallaPageModule)
  },
  {
    path: 'add-color',
    loadChildren: () => import('./mantenimiento/articulos/color/add-color/add-color.module').then( m => m.AddColorPageModule)
  },
  {
    path: 'ver-color',
    loadChildren: () => import('./mantenimiento/articulos/color/ver-color/ver-color.module').then( m => m.VerColorPageModule)
  },
  {
    path: 'ver-articulo',
    loadChildren: () => import('./mantenimiento/articulos/ver-articulo/ver-articulo.module').then( m => m.VerArticuloPageModule)
  },
  {
    path: 'add-articulo',
    loadChildren: () => import('./mantenimiento/articulos/add-articulo/add-articulo.module').then( m => m.AddArticuloPageModule)
  },
  {
    path: 'pruebacdk',
    loadChildren: () => import('./pruebacdk/pruebacdk.module').then( m => m.PruebacdkPageModule)
  },
  {
    path: 'ver-tarifas',
    loadChildren: () => import('./mantenimiento/tarifas/ver-tarifas/ver-tarifas.module').then( m => m.VerTarifasPageModule)
  },
  {
    path: 'add-tarifas',
    loadChildren: () => import('./mantenimiento/tarifas/add-tarifas/add-tarifas.module').then( m => m.AddTarifasPageModule)
  },
  {
    path: 'ver-tipo',
    loadChildren: () => import('./mantenimiento/tarifas/tipo/ver-tipo/ver-tipo.module').then( m => m.VerTipoPageModule)
  },
  {
    path: 'add-tipo',
    loadChildren: () => import('./mantenimiento/tarifas/tipo/add-tipo/add-tipo.module').then( m => m.AddTipoPageModule)
  },
  {
    path: 'ver-categoria-t',
    loadChildren: () => import('./mantenimiento/tarifas/categoria/ver-categoria-t/ver-categoria-t.module').then( m => m.VerCategoriaTPageModule)
  },  {
    path: 'add-categoria-t',
    loadChildren: () => import('./mantenimiento/tarifas/categoria/add-categoria-t/add-categoria-t.module').then( m => m.AddCategoriaTPageModule)
  }









];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
