<?php

namespace App\Providers;

use App\Diary\AI\OpenAiClient;
use Illuminate\Database\Eloquent\Model;
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
        $this->app->bind(OpenAiClient::class, function () {
            $client = (new \Orhanerday\OpenAi\OpenAi(config('services.open_ai.key')));
            if ($orgKey = config('services.open_ai.organization')) {
                $client->setORG($orgKey);
            }

            return new OpenAiClient($client);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::unguard();
    }
}
