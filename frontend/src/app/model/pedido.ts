export interface Pedido{
    id: number;
    parte_trabajo: boolean;
    esta_firmado: boolean;
    fecha_terminacion_trabajo: string;
    observaciones: string;
    validado: boolean;
    id_estado: number;
    id_individual: number;
    id_empresa: number;
    id_usuario: number;
    logotipos: string;
    tarifas: string;
    articulos: string
}