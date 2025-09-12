<?php

namespace Boy132\Register\Filament\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Schemas\Components\Component;

class Register extends BaseRegister
{
    protected function getNameFormComponent(): Component
    {
        return parent::getNameFormComponent()
            ->name('username')
            ->statePath('username');
    }
}
