<?php

namespace Modules\Admin\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\PluginServiceProvider;
use Livewire\Livewire;
use Modules\Admin\Filament\Resources\RoleResource;
use Modules\Admin\Filament\Resources\UserResource;
use Spatie\LaravelPackageTools\Package;

class FilamentServiceProvider extends PluginServiceProvider
{
    private array $resourceNames=[
        'User',
        'Role',
    ];
    public function isEnabled(): bool{
        $module = \Module::find('admin');
        return $module->isEnabled()??false;
    }
    public function configurePackage(Package $package): void
    {
        $package->name('admin');
    }

    public function getResources(): array
    {

        foreach ($this->resourceNames as $name){
            $this->resources[]="Modules\\Admin\\Filament\\Resources\\{$name}";
        }
        return ($this->isEnabled())?$this->resources:[];
    }

    public function getPages(): array
    {
        return ($this->isEnabled())?$this->pages:[];
    }

    public function boot():void
    {
        foreach ($this->resourceNames as $name){
            Livewire::component("Create{$name}","Modules\\Admin\\Filament\\Resources\\{$name}Resource\\Pages\\Create{$name}");
            Livewire::component("Edit{$name}","Modules\\Admin\\Filament\\Resources\\{$name}Resource\\Pages\\Edit{$name}");
        }
        Filament::serving(function (){
            if(config('admin.navigation-group.enabled'))
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label(config('admin.navigation-group.name'))
            ]);
        });
    }
}
