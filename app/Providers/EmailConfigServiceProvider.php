<?php

namespace App\Providers;

use App\Models\EmailConfig;
use App\Repositories\EmailConfigRepository;
use App\Services\EmailConfigService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

/**
 * Class EmailConfigServiceProvider
 * @package App\Providers
 */
class EmailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('email_configs')) {
            $emailConfigService = new EmailConfigService(
                new EmailConfigRepository(
                    new EmailConfig()
                )
            );

            if ($config = $emailConfigService->getEmailConfig()) {
                if ($config->active) {
                    $config = [
                        'driver' => $config->mailer,
                        'host' => $config->host,
                        'port' => $config->port,
                        'username' => $config->username,
                        'password' => $config->password,
                        'encryption' => $config->encryption,
                        'from' => [
                            'address' => $config->from_address,
                            'name' => $config->from_name
                        ],
                    ];

                    Config::set('mail', $config);
                }
            }
        }
    }
}
