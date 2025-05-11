<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
/**



* Registra cualquier servicio de la aplicación.
*
* @return void
*/
    public function register()
    {
    // Registrar servicios
    }
    /**
    * Realiza las operaciones de arranque para la aplicación.
    *
    * @return void
    */
    
    public function boot(Router $router)
    {
    // Nuevo
    $router->aliasMiddleware('role',
    \Spatie\Permission\Middleware\RoleMiddleware::class);

    Paginator::useBootstrap();
    }
}
