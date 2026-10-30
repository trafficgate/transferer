<?php

namespace Trafficgate\Transferer\Providers;

use Illuminate\Support\ServiceProvider;
use Trafficgate\Transferer\Console\Commands\Rsync;
use Trafficgate\Transferer\Console\Commands\Scp;
use Trafficgate\Transferer\Daemon\RsyncDaemon;
use Trafficgate\Transferer\Transfer\RsyncTransfer;
use Trafficgate\Transferer\Transfer\ScpTransfer;

class TransfererServiceProvider extends ServiceProvider
{
    public const PACKAGE_NAME = 'transferer';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('scp-transfer', function ($app) {
            return (new ScpTransfer())->setLogger($app['log']);
        });

        $this->app->singleton('rsync-transfer', function ($app) {
            return (new RsyncTransfer())->setLogger($app['log']);
        });

        $this->app->singleton('rsync-daemon', function ($app) {
            return (new RsyncDaemon())->setLogger($app['log']);
        });

        $this->app->alias('scp-transfer', ScpTransfer::class);

        $this->app->singleton('command.scp', function ($app) {
            return new Scp($app['scp-transfer']);
        });

        $this->app->singleton('command.rsync', function ($app) {
            return new Rsync($app['rsync-transfer']);
        });

        $this->commands([
            'command.rsync',
            'command.scp',
        ]);
    }

    /**
     * Bootstrap the application services.
     */
    public function boot() {}

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.rsync',
            'command.scp',
            'scp-transfer',
        ];
    }
}
