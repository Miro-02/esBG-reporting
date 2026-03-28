<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulesPath = base_path('modules');
        
        if (File::exists($modulesPath)) {
            $modules = File::directories($modulesPath);
            
            foreach ($modules as $module) {
                $moduleName = basename($module);
                $this->loadModuleRoutes($module, $moduleName);
                $this->loadModuleMigrations($module);
            }
        }
    }

    protected function loadModuleRoutes(string $modulePath, string $moduleName): void
    {
        $routesPath = $modulePath . '/Routes/api.php';
        
        if (File::exists($routesPath)) {
            Route::prefix('api/' . strtolower($moduleName))
                ->middleware('api')
                ->group($routesPath);
        }
    }

    protected function loadModuleMigrations(string $modulePath): void
    {
        $migrationsPath = $modulePath . '/Database/Migrations';
        
        if (File::exists($migrationsPath)) {
            $this->loadMigrationsFrom($migrationsPath);
        }
    }
}