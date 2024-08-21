<?php
namespace App\Providers;

use App\Events\OnStart;
use App\Repositories\ConfigSettingsRepository;
use App\View\Components\Dropzone;
use App\View\Components\SumPrice;
use Exception;
use Carbon\Carbon;
use App\Http\Kernel;
use App\Models\ConfigOffer;
use App\View\Components\Invoice\Footer;
use App\View\Components\Invoice\Header;
use App\View\Components\Invoice\Konto;
use App\View\Components\Invoice\Prices as InvoicePrices;
use App\View\Components\Invoice\GuestPrices as InvoiceGuestPrices;
use App\View\Components\Show\Prices as ShowPrices;
use App\View\Components\Show\GuestPrices as ShowGuestPrices;
use App\View\Components\Invoice\RecipentHeader;
use App\View\Components\Button\BackButton;
use App\View\Components\Button\CreateButton;
use App\View\Components\Button\DeleteButton;
use App\View\Components\Button\EditButton;
use App\View\Components\Button\InvoiceButton;
use App\View\Components\Button\PrintButton;
use App\View\Components\Button\ResetButton;
use App\View\Components\Button\ShowButton;
use App\View\Components\Button\InfoButton;
use App\View\Components\Form\Excel;
use App\View\Components\Form\Filter;
use App\View\Components\Table\Action;
use App\View\Components\Table\Table;
use App\View\Components\Table\Td;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\View\Components\Navigation\PublicBottomNavbar;
use App\View\Components\Navigation\PublicTopNavbar;
use Jenssegers\Agent\Agent;

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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        $agent = new Agent();
        $isMobile = true === $agent->isPhone() || true === $agent->isTablet();

        View::share('isMobile', fn() => (bool) $isMobile);
        View::share('isNotMobile', fn() => (bool) !$isMobile);

        $locale = config('app.locale');
        Carbon::setLocale($locale);
        setlocale(LC_TIME, $locale, 'de_DE.utf8', 'de');
        URL::forceScheme(env('FORCE_SCHEME', 'http'));
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Blade::if('adminOrCustomer', function () {
            return auth('admin')->check() || auth('customer')->check();
        });
        Blade::if('isCustomer', function () {
            return auth('customer')->check();
        });
        Blade::if('isAdmin', function () {
            return auth('admin')->check();
        });
		Blade::if('adminCan', function (string $perms) {
			return auth('admin')->check() && auth('admin')->user()->can($perms);
		});
		Blade::if('customerCan', function (string $perms) {
			return auth('customer')->check() && auth('customer')->user()->can($perms);
		});

        Blade::if('isMobile', fn () => $agent->isPhone() || $agent->isTablet());
        Blade::components([
            'table'         => Table::class,
            'td'            => Td::class,
            'action'        => Action::class,
            'btn-create'    => CreateButton::class,
            'btn-edit'      => EditButton::class,
            'btn-delete'    => DeleteButton::class,
            'btn-back'      => BackButton::class,
            'btn-show'      => ShowButton::class,
            'btn-info'      => InfoButton::class,
            'btn-print'     => PrintButton::class,
            'btn-reset'     => ResetButton::class,
            'btn-invoice'   => InvoiceButton::class,
            'filter'        => Filter::class,
            'frm-excel'     => Excel::class,
            'recipient-header'  => RecipentHeader::class,
            'invoice-header'    => Header::class,
            'invoice-konto'     => Konto::class,
            'invoice-prices'    => InvoicePrices::class,
            'invoice-guest-prices' => InvoiceGuestPrices::class,
            'show-prices'       => ShowPrices::class,
            'show-guest-prices' => ShowGuestPrices::class,
            'invoice-footer'    => Footer::class,
            'public-top-navbar' => PublicTopNavbar::class,
            'public-bottom-navbar' => PublicBottomNavbar::class,
            'sum-price'         => SumPrice::class,
			'dropzone'          => Dropzone::class,
        ]);
        try {
            $settings = ConfigSettingsRepository::getFirst();
            Config::set('settings', $settings);
            $offers = ConfigOffer::all();
            Config::set('offers', $offers->keyBy('name')->map->enabled);
            $menuConfig = config('port.menu.admin.items');

            foreach ($offers as $offer) {
                if(isset($menuConfig[$offer->name]) && !$offer->enabled) {
					Config::offsetUnset('port.menu.admin.items.'.$offer->name);
                }
            }
        } catch (Exception $e) {}
    }
}
