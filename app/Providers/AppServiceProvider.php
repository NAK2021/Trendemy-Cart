<?php

namespace App\Providers;

<<<<<<< HEAD
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
=======
use App\Models\Cart;
use App\Policies\CartPolicy;
use App\Services\CartService;
use App\Services\MomoService;
use App\Services\OrderService;
use App\Services\VNPayService;
use App\Services\CouponService;
use App\Services\CourseService;
use App\Repositories\CartRepository;
use App\Repositories\ConfigRepository;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Gate;
use App\Repositories\OrderRepository;
use App\Repositories\CouponRepository;
use App\Repositories\CourseRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\OrderDetailRepository;
use App\Repositories\TransactionRepository;
use App\Services\Interfaces\CartServiceInterface;
use App\Services\Interfaces\MomoServiceInterface;
use App\Services\Interfaces\OrderServiceInterface;
use App\Services\Interfaces\VNPayServiceInterface;
use App\Services\Interfaces\CouponServiceInterface;
use App\Services\Interfaces\CourseServiceInterface;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\ConfigRepositoryInterface;
use App\Services\Interfaces\TransactionServiceInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\OrderDetailRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Services\BankService;
use App\Services\ConfigService;
use App\Services\Interfaces\BankServiceInterface;
use App\Services\Interfaces\ConfigServiceInterface;

class AppServiceProvider extends ServiceProvider
{

>>>>>>> b80dd2f (init commit)
    public function register(): void
    {
        //
    }

<<<<<<< HEAD
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
=======
    public function boot(): void
    {

        # inject courses
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(CourseServiceInterface::class, CourseService::class);

        # inject carts
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(CartServiceInterface::class, CartService::class);

        # inject transaction
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);

        # inject coupons
        $this->app->bind(CouponRepositoryInterface::class, CouponRepository::class);
        $this->app->bind(CouponServiceInterface::class, CouponService::class);

        # inject orders
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);

        # inject order_details
        $this->app->bind(OrderDetailRepositoryInterface::class, OrderDetailRepository::class);

        # inject discount condition
        // $this->app->bind(DiscountConditionRepositoryInterface::class, DiscountConditionRepository::class);
        // $this->app->bind(DiscountConditionServiceInterface::class, DiscountConditionService::class);


        # inject config
        $this->app->bind(ConfigRepositoryInterface::class, ConfigRepository::class);
        $this->app->bind(ConfigServiceInterface::class, ConfigService::class);

        #Bank Payment
        $this->app->bind(BankServiceInterface::class, BankService::class);

        # inject vnpay
        $this->app->bind(VNPayServiceInterface::class, VNPayService::class);
        # inject momo
        $this->app->bind(MomoServiceInterface::class, MomoService::class);


        #Policies
        Gate::policy(Cart::class, CartPolicy::class);
>>>>>>> b80dd2f (init commit)
    }
}
