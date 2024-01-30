<?php

namespace App\Providers;

use App\Models\BrandProduct;
use App\Models\ProductCategory;
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
     */
    public function boot(): void
    {
        view()->composer('*',function($view){
            $view->with([
                'productCategories'=> ProductCategory::where('status',1)->orderBy('name','DESC')->get(),
                'brandProducts'=> BrandProduct::where('status',1)->orderBy('name','DESC')->get(),
            ]);
        });
    }
}
