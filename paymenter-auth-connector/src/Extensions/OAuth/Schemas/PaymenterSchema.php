<?php

namespace OpenCode\PaymenterAuthConnector\Extensions\OAuth\Schemas;

use App\Extensions\OAuth\Schemas\OAuthSchema;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Wizard\Step;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use OpenCode\PaymenterAuthConnector\Extensions\OAuth\Providers\PaymenterProvider;

final class PaymenterSchema extends OAuthSchema
{
    public function getId(): string
    {
        return 'paymenter';
    }

    public function getSocialiteProvider(): string
    {
        return PaymenterProvider::class;
    }

    public function getServiceConfig(): array
    {
        return array_merge(parent::getServiceConfig(), [
            'base_url' => env('OAUTH_PAYMENTER_BASE_URL'),
            'authorize_path' => env('OAUTH_PAYMENTER_AUTHORIZE_PATH', '/oauth/authorize'),
            'token_path' => env('OAUTH_PAYMENTER_TOKEN_PATH', '/api/oauth/token'),
            'user_path' => env('OAUTH_PAYMENTER_USER_PATH', '/api/me'),
        ]);
    }

    public function getSetupSteps(): array
    {
        return array_merge([
            Step::make('Create Paymenter OAuth App')
                ->schema([
                    TextEntry::make('instructions')
                        ->hiddenLabel()
                        ->state(new HtmlString(Blade::render('
                            <ol class="list-decimal list-inside space-y-1">
                                <li>Open your Paymenter admin dashboard</li>
                                <li>Go to <strong>OAuth Clients</strong> and create a new client</li>
                                <li>Set the redirect URL to the callback URL shown below</li>
                                <li>Copy the generated <strong>Client ID</strong> and <strong>Client Secret</strong></li>
                            </ol>
                            <p class="mt-2">Reference: <x-filament::link href="https://paymenter.org/development/OAuth" target="_blank">Paymenter OAuth docs</x-filament::link></p>
                        '))),
                    TextInput::make('_noenv_callback')
                        ->label('Callback URL')
                        ->dehydrated()
                        ->disabled()
                        ->hintCopy()
                        ->default(fn () => url('/auth/oauth/callback/paymenter')),
                ]),
        ], parent::getSetupSteps());
    }

    public function getSettingsForm(): array
    {
        return array_merge(parent::getSettingsForm(), [
            TextInput::make('OAUTH_PAYMENTER_BASE_URL')
                ->label('Base URL')
                ->placeholder('https://billing.example.com')
                ->columnSpan(2)
                ->required()
                ->url()
                ->autocomplete(false)
                ->default(env('OAUTH_PAYMENTER_BASE_URL')),
            TextInput::make('OAUTH_PAYMENTER_AUTHORIZE_PATH')
                ->label('Authorize Path')
                ->placeholder('/oauth/authorize')
                ->columnSpan(2)
                ->required()
                ->autocomplete(false)
                ->default(env('OAUTH_PAYMENTER_AUTHORIZE_PATH', '/oauth/authorize')),
            TextInput::make('OAUTH_PAYMENTER_TOKEN_PATH')
                ->label('Token Path')
                ->placeholder('/api/oauth/token')
                ->columnSpan(2)
                ->required()
                ->autocomplete(false)
                ->default(env('OAUTH_PAYMENTER_TOKEN_PATH', '/api/oauth/token')),
            TextInput::make('OAUTH_PAYMENTER_USER_PATH')
                ->label('User Path')
                ->placeholder('/api/me')
                ->columnSpan(2)
                ->required()
                ->autocomplete(false)
                ->default(env('OAUTH_PAYMENTER_USER_PATH', '/api/me')),
            TextInput::make('OAUTH_PAYMENTER_DISPLAY_NAME')
                ->label('Display Name')
                ->placeholder('Paymenter')
                ->autocomplete(false)
                ->default(env('OAUTH_PAYMENTER_DISPLAY_NAME', 'Paymenter')),
            ColorPicker::make('OAUTH_PAYMENTER_DISPLAY_COLOR')
                ->label('Display Color')
                ->placeholder('#0ea5e9')
                ->default(env('OAUTH_PAYMENTER_DISPLAY_COLOR', '#0ea5e9'))
                ->hex(),
        ]);
    }

    public function getName(): string
    {
        return env('OAUTH_PAYMENTER_DISPLAY_NAME', 'Paymenter');
    }

    public function getIcon(): string
    {
        return 'tabler-credit-card';
    }

    public function getHexColor(): string
    {
        return env('OAUTH_PAYMENTER_DISPLAY_COLOR', '#0ea5e9');
    }
}
