<?php

namespace Modules\Admin\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Modules\Admin\Filament\Pages\AdminPage;

class FilamentServiceProvider extends PluginServiceProvider
{
    public function isEnabled(): bool{
        $module = \Module::find('admin');
        return $module->isEnabled();
    }
    protected array $pages = [
        AdminPage::class,
    ];
    protected array $resources =[];
    public function configurePackage(Package $package): void
    {
        $package->name('admin');
    }

    public function getResources(): array
    {
        return ($this->isEnabled())?$this->resources:[];
    }

    public function getPages(): array
    {
        return ($this->isEnabled())?$this->pages:[];
    }

    public function boot():void
    {
        Filament::serving(function (){
            if(config('admin.navigation-group.enabled'))
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label(config('admin.navigation-group.name'))
            ]);
        });
    }
}
