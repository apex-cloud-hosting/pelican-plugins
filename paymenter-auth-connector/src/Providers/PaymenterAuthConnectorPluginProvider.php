<?php

namespace OpenCode\PaymenterAuthConnector\Providers;

use App\Extensions\OAuth\OAuthService;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use OpenCode\PaymenterAuthConnector\Extensions\OAuth\Schemas\PaymenterSchema;

class PaymenterAuthConnectorPluginProvider extends ServiceProvider
{
    public function boot(): void
    {
        $service = $this->app->make(OAuthService::class);
        $service->register(new PaymenterSchema());

        FilamentView::registerRenderHook(
            PanelsRenderHook::SCRIPTS_AFTER,
            fn () => Blade::render(<<<'HTML'
                <script>
                    document.addEventListener('click', function (event) {
                        const link = event.target.closest('a[href*="/auth/oauth/redirect/paymenter"]');

                        if (!link) {
                            return;
                        }

                        if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
                            return;
                        }

                        event.preventDefault();
                        window.location.assign(link.href);
                    }, true);
                </script>
            HTML),
        );
    }
}
