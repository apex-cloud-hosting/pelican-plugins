<?php

namespace OpenCode\PaymenterAuthConnector;

use Filament\Contracts\Plugin;
use Filament\Panel;

class PaymenterAuthConnectorPlugin implements Plugin
{
    public function getId(): string
    {
        return 'paymenter-auth-connector';
    }

    public function register(Panel $panel): void {}

    public function boot(Panel $panel): void {}
}
