<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use App\Providers\URL;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    //
    Validator::extend('kana', function ($attribute, $value, $parameters, $validator) {
      return preg_match('/[ァ-ヴー]+/u', $value);
    });
    if ($this->app->environment() == 'production') {
      URL::forceScheme('https');
    };
  }
}
