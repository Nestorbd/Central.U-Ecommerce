export interface Tarifa{
    id: number;
    nombre: string;
    precio: number;
    fecha_creacion: string;
    fecha_actualizacion: string;
    activo: boolean;
    id_categoria: number;
    id_tipo: number;
}