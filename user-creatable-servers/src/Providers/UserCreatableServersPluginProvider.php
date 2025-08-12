<?php

namespace Boy132\UserCreatableServers\Providers;

use App\Enums\HeaderActionPosition;
use App\Enums\HeaderWidgetPosition;
use App\Filament\Admin\Resources\UserResource;
use App\Filament\App\Resources\ServerResource\Pages\ListServers;
use Boy132\UserCreatableServers\Filament\Admin\Resources\UserResource\RelationManagers\UserResourceLimitRelationManager;
use Boy132\UserCreatableServers\Filament\App\Widgets\UserResourceLimitsOverview;
use Boy132\UserCreatableServers\Filament\Components\Actions\CreateServerAction;
use Illuminate\Support\ServiceProvider;

class UserCreatableServersPluginProvider extends ServiceProvider
{
    public function register(): void
    {
        UserResource::registerCustomRelations(UserResourceLimitRelationManager::class);

        ListServers::registerCustomHeaderWidgets(HeaderWidgetPosition::Before, UserResourceLimitsOverview::class);

        ListServers::registerCustomHeaderActions(HeaderActionPosition::Before, CreateServerAction::make());
    }

    public function boot(): void {}
}
