<?php

namespace App\Providers;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //注册elasticsearch服务
        $this->app->singleton(Client::class,function ($app){
            return ClientBuilder::create()
                ->setHosts(config('elasticsearch.hosts'))
                ->setBasicAuthentication('elastic', config('elasticsearch.password')) // 如果启用了安全功能
                ->build();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
