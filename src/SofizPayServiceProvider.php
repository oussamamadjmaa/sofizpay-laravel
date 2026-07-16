<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay;

use Illuminate\Support\ServiceProvider;

/**
 * Registers the SofizPay client and its publishable configuration.
 */
final class SofizPayServiceProvider extends ServiceProvider
{
    /**
     * Register the package configuration for publishing.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/sofizpay.php' => config_path('sofizpay.php'),
        ], 'config');
    }

    /**
     * Register the package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/sofizpay.php', 'sofizpay'
        );

        $this->app->singleton('sofizpay', fn () => new SofizPay());

        $this->app->alias('sofizpay', SofizPay::class);
    }

    /**
     * @return array<int, class-string|string>
     */
    public function provides(): array
    {
        return ['sofizpay', SofizPay::class];
    }
}
