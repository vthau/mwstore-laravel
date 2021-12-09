<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use App\Observers\ProductObserver;
use App\Models\Gallery;
use App\Observers\GalleryObserver;
use App\Models\Slider;
use App\Observers\SliderObserver;
use App\Models\User;
use App\Observers\UserObserver;
use App\Models\Admin;
use App\Observers\AdminObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**I
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // URL::forceScheme('https');

        Blade::directive('money', function ($price) {
            return "<?php echo number_format($price, 0, '', '.')  .  ' VNĐ'; ?>";
        });

        Product::observe(ProductObserver::class);
        Gallery::observe(GalleryObserver::class);
        Slider::observe(SliderObserver::class);
        User::observe(UserObserver::class);
        Admin::observe(AdminObserver::class);
    }
}
