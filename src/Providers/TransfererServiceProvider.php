<?php

namespace Trafficgate\Providers;

use Illuminate\Support\ServiceProvider;
use Trafficgate\Console\Commands\Rsync;
use Trafficgate\Console\Commands\Scp;
use Trafficgate\Console\Commands\ScpImpressionLogs;
use Trafficgate\Daemon\RsyncDaemon;
use Trafficgate\Transfer\RsyncTransfer;
use Trafficgate\Transfer\ScpTransfer;

class TransfererServiceProvider extends ServiceProvider
{
    const PACKAGE_NAME = 'transferer';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('scp-transfer', function ($app) {
            $scpTransfer = new ScpTransfer()->setLogger($app('log'));

            return $scpTransfer;
        });

        $this->app->singleton('rsync-transfer', function ($app) {
            $rsyncTransfer = new RsyncTransfer()->setLogger($app('log'));

            return $rsyncTransfer;
        });

        $this->app->singleton('rsync-daemon', function ($app) {
            $rsyncTransfer = new RsyncDaemon()->setLogger($app('log'));

            return $rsyncTransfer;
        });

        $this->app->alias('scp-transfer', ScpTransfer::class);

        $this->app['command.scp'] = $this->app->share(function ($app) {
            return new Scp($app['scp-transfer']);
        });

        $this->app['command.rsync'] = $this->app->share(function ($app) {
            return new Rsync($app['rsync-transfer']);
        });

        $this->commands([
            'command.rsync',
            'command.scp',
        ]);
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

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
