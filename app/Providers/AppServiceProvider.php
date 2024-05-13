<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('downloadOrInputFile', function ($expression) {
            return "<?php if(file_exists($expression)): ?> <a href=\"{{ route('download', $expression) }}\" class=\"btn btn-primary\">Download File</a> <?php else: ?> <input type=\"file\" class=\"form-control\" style=\"width:120px;\" name=\"slips1\"> <?php endif; ?>";
        });
    }
}
