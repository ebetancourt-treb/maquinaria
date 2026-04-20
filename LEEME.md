# Maquinaria Lago de Guadalupe — Bitácora

## Instalación

### Requisito: Proyecto Laravel con Breeze ya instalado

Si aún no lo tienes:
```bash
composer create-project laravel/laravel maquinaria-lago
cd maquinaria-lago
composer require laravel/breeze --dev
php artisan breeze:install blade
```

### 1. Instalar paquetes requeridos
```bash
composer require spatie/laravel-permission
composer require maatwebsite/laravel-excel
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

### 2. NPM
```bash
npm install
npm install tom-select @fortawesome/fontawesome-free
```

Agregar en `resources/css/app.css`:
```css
@import 'tom-select/dist/css/tom-select.css';
@import '@fortawesome/fontawesome-free/css/all.css';
```

Agregar en `resources/js/app.js`:
```js
import TomSelect from 'tom-select';
window.TomSelect = TomSelect;
```

### 3. Descomprimir este ZIP
Copia todos los archivos de este ZIP en la raíz de tu proyecto.
Sobrescribirá: routes/web.php, database/seeders/*.

### 4. Modificar User.php (MANUAL)
Edita `app/Models/User.php` y agrega:

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;  // ← agregar HasRoles

    protected $fillable = [
        'name', 'email', 'password',
        'telefono', 'puesto', 'activo',   // ← agregar estos 3
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'activo' => 'boolean',            // ← agregar
    ];

    // ← agregar estos métodos:
    public function maquinariasAsignadas()
    {
        return $this->hasMany(\App\Models\Maquinaria::class, 'responsable_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
```

### 5. Modificar navigation.blade.php (MANUAL)
Abre `resources/views/layouts/navigation.blade.php` y:

- Reemplaza los `<x-nav-link>` dentro de `<!-- Navigation Links -->` 
  con el contenido de `resources/views/layouts/_nav-links.blade.php`

- Reemplaza el `<div class="pt-2 pb-3 space-y-1">` dentro del 
  `<!-- Responsive Navigation Menu -->` con el contenido de 
  `resources/views/layouts/_nav-responsive.blade.php`

### 6. Compilar y migrar
```bash
npm run build
php artisan migrate:fresh --seed
```

### 7. Acceder
- URL: http://localhost:8000
- Admin: admin@maquinaria.test / password

---

## Estructura del proyecto

```
app/
├── Http/Controllers/
│   ├── DashboardController.php
│   ├── MaquinariaController.php
│   ├── BitacoraController.php
│   ├── ImportController.php
│   ├── UserController.php
│   └── Catalogos/ (5 controllers + trait)
├── Http/Requests/
│   ├── MaquinariaRequest.php
│   └── BitacoraRegistroRequest.php
├── Imports/MaquinariasImport.php
├── Models/ (7 modelos)
├── Services/BitacoraService.php
database/
├── migrations/ (8 migraciones)
├── seeders/ (4 seeders)
resources/views/
├── dashboard/index.blade.php
├── maquinarias/ (5 vistas)
├── bitacora/ (4 vistas + 2 partials)
├── catalogos/ (3 shared + 5 subcarpetas)
├── usuarios/ (4 vistas)
├── import/ (1 modal)
├── components/badge.blade.php
routes/web.php
```

## Roles
- **admin**: Acceso total
- **supervisor**: Opera sin gestionar usuarios
- **operador**: Solo consulta + registrar en bitácora
