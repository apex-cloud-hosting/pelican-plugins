<?php

namespace Boy132\Billing\Providers\Filament;

use App\Filament\App\Resources\Servers\Pages\ListServers;
use App\Providers\Filament\PanelProvider;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Panel;

class ShopPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel
            ->id('shop')
            ->path('')
            ->homeUrl('/');

        return parent::panel($panel)
            ->breadcrumbs(false)
            ->navigation(false)
            ->topbar(true)
            ->userMenuItems([
                Action::make('to_serverList')
                    ->label(trans('profile.server_list'))
                    ->icon('tabler-brand-docker')
                    ->url(fn () => ListServers::getUrl(panel: 'app')),
                Action::make('to_admin')
                    ->label(trans('profile.admin'))
                    ->icon('tabler-arrow-forward')
                    ->url(fn () => Filament::getPanel('admin')->getUrl())
                    ->visible(fn () => user()?->canAccessPanel(Filament::getPanel('admin'))),
            ])
            ->discoverResources(in: app_path('Filament/Shop/Resources'), for: 'App\\Filament\\Shop\\Resources')
            ->discoverPages(in: app_path('Filament/Shop/Pages'), for: 'App\\Filament\\Shop\\Pages')
            ->discoverWidgets(in: app_path('Filament/Shop/Widgets'), for: 'App\\Filament\\Shop\\Widgets');
    }
}
