<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\StockProduct;
use App\Models\Supplier;
use App\Models\User;
use App\Policies\CustomerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\PurchasePolicy;
use App\Policies\SalePolicy;
use App\Policies\StockProductPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Class::class => ClassPolicy::class,
        Customer::class => CustomerPolicy::class,
        Product::class => ProductPolicy::class,
        Purchase::class => PurchasePolicy::class,
        Sale::class => SalePolicy::class,
        StockProduct::class => StockProductPolicy::class,
        Supplier::class => SupplierPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
