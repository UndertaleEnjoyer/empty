<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * В Laravel 12 отдельного AuthServiceProvider нет — Gate-правила
     * (политики доступа) регистрируются здесь, в boot() AppServiceProvider.
     */
    public function boot(): void
    {
        // Право на удаление команды — только у администратора
        Gate::define('delete-team', function (User $user) {
            return $user->is_admin;
        });

        // Право на редактирование (обновление) команды — только у администратора
        Gate::define('update-team', function (User $user) {
            return $user->is_admin;
        });
    }
}
