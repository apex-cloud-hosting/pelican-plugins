<?php

namespace Boy132\Billing\Filament\Shop\Pages;

use Boy132\Billing\Filament\Shop\Widgets\ProductWidget;
use Boy132\Billing\Filament\Shop\Widgets\WelcomeWidget;
use Boy132\Billing\Models\Product;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\WidgetConfiguration;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        $widgets = [new WidgetConfiguration(WelcomeWidget::class)];

        foreach (Product::all() as $product) {
            $widgets[] = new WidgetConfiguration(ProductWidget::class, ['product' => $product]);
        }

        return $widgets;
    }
}
