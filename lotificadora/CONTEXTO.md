# Contexto del Proyecto - Lotificadora

## Cambios Realizados

### 1. Total Cobrado por Residencial

**Archivos modificados:**
- `app/Http/Controllers/controladorResidenciales.php`
  - En `show($id)`: consulta SQL que suma todos los pagos (`cantidad_pago`) de `fechas_cobros` con estado `'Pagado'` cuyas ventas pertenezcan al residencial. Devuelve `totalCobrado` en el JSON.
  - En `index()`: misma lógica para mostrar en tarjetas principales.

- `resources/js/components/registrarResidenciales/ResidencialesComponent.vue`
  - Muestra `Cobrado: L. {{residencial.totalCobrado}}` en cada tarjeta.

- `resources/js/components/registrarResidenciales/modalBloquesComponent.vue`
  - Muestra `Total Cobrado: L. {{residencial.totalCobrado}}` en el modal de detalle.

### 2. Fix de Compilación (Node.js v26 + Laravel Mix 6)

**Archivos creados:**
- `fix-yargs.cjs` — script postinstall que remueve `"type": "module"` del `package.json` de `yargs` (dependencia de Laravel Mix incompatible con Node.js v26).

**Archivos modificados:**
- `package.json` — se agregó script `postinstall: node fix-yargs.cjs`.

### 3. Resumen Financiero por Residencial

**Archivos creados:**
- `routes/web.php` — ruta `GET /residenciales/{id}/resumen-financiero`
- `app/Http/Controllers/HomeController.php` — método `resumen_financiero($id)` con consultas de:
  - Resumen general: total esperado, total cobrado, ventas pagadas/pendientes
  - Detalle por venta: cliente, lotes, monto esperado, cobrado, saldo
  - Lotes agrupados por venta
- `resources/views/registrarResidenciales/resumenFinanciero.blade.php`
- `resources/js/components/registrarResidenciales/resumenFinancieroComponent.vue` — componente con:
  - 4 tarjetas de resumen (Total Esperado, Total Recaudado, Pendiente, % Recaudado)
  - Tabla resumen general (ventas, pagadas, pendientes)
  - DataTable detalle por venta con búsqueda, paginación y selector de registros
  - Botones de paginación con estilo Bootstrap
  - Columna "Acción" con botón "Ver" que navega al detalle de cada venta

**Archivos modificados:**
- `resources/js/app.js` — registro del componente `resumen-financiero-component`
- `resources/js/components/registrarResidenciales/modalBloquesComponent.vue` — botón "Resumen Financiero" en el modal que abre la página en nueva pestaña

### 4. Detalle de Venta desde Resumen Financiero

**Archivos creados:**
- `routes/web.php` — ruta `GET /residenciales/venta/{id}/detalle`
- `app/Http/Controllers/HomeController.php` — método `detalle_venta($id)` que consulta venta, cliente, lotes e historial de cuotas
- `resources/views/registrarResidenciales/detalleVentaFinanciero.blade.php`
- `resources/js/components/registrarResidenciales/detalleVentaFinancieroComponent.vue` — componente con:
  - Información del cliente (nombre, identidad, teléfonos, correo, dirección)
  - Resumen de la venta (estado, tipo pago, totales, saldo pendiente)
  - Detalles de financiamiento (años, tasa, prima, cuotas, intereses)
  - Tabla de lotes comprados
  - Historial de cuotas con colores de estado (Pagado, Pendiente, Atrasado, etc.)
  - Botón "Volver" con `history.back()`

**Archivos modificados:**
- `resources/js/app.js` — registro del componente `detalle-venta-financiero-component`
- `resources/js/components/registrarResidenciales/resumenFinancieroComponent.vue` — columna "Acción" con botón "Ver"

## Estructura de la Base de Datos

Las tablas principales y sus relaciones:

```
residenciales → bloques → lotes → lotes_vendidos → ventas → fechas_cobros
                                  → clientes
```

- `residenciales`: proyectos residenciales
- `bloques`: bloques dentro de un residencial (A, B, C...)
- `lotes`: lotes individuales con precio, área, medidas
- `clientes`: compradores con datos personales
- `ventas`: transacciones de venta (contado o crédito)
- `lotes_vendidos`: relación muchos-a-muchos entre ventas y lotes
- `fechas_cobros`: plan de pagos/cuotas de cada venta a crédito
- `beneficiarios`: beneficiarios vinculados a clientes

## Flujo de Navegación

```
/registrarResidenciales
  ├── [Entrar] → modalBloques → [Resumen Financiero] → /residenciales/{id}/resumen-financiero
  │                                                       └── [Ver] → /residenciales/venta/{id}/detalle
  └── [Registrar Residencial] → modalRegistrarResidencial
```

## Responsive

La tabla de detalle en el resumen financiero usa DataTables con:
- `pagingType: 'full_numbers'` (paginación completa con número de páginas)
- `dom` con layout Bootstrap (búsqueda + selector arriba, info + paginación abajo)
- CSS personalizado para botones de paginación con estilo Bootstrap
- Sin scroll horizontal
- `container-fluid` para máximo ancho
