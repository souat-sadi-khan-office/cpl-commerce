<?php

namespace App\Providers;

use App\Repositories\TaxRepository;
use App\Repositories\AuthRepository;
use App\Repositories\CartRepository;
use App\Repositories\CityRepository;
use App\Repositories\PageRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\ZoneRepository;
use App\Repositories\AdminRepository;
use App\Repositories\BrandRepository;
use App\Repositories\OrderRepository;
use App\Repositories\BannerRepository;
use App\Repositories\AddressRepository;
use App\Repositories\CountryRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\LocationRepository;
use App\Repositories\BrandTypeRepository;
use App\Repositories\CustomerQuestionRepository;
use App\Repositories\DashboardRepository;
use App\Repositories\FlashDealRepository;
use App\Repositories\PcBuilderRepository;
use App\Repositories\PhoneBookRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ProductStockRepository;
use App\Repositories\GatewayConfigurationRepository;
use App\Repositories\ProductSpecificationRepository;
use App\Repositories\Interface\TaxRepositoryInterface;
use App\Repositories\Interface\AuthRepositoryInterface;
use App\Repositories\Interface\CartRepositoryInterface;
use App\Repositories\Interface\CityRepositoryInterface;
use App\Repositories\Interface\PageRepositoryInterface;
use App\Repositories\Interface\RoleRepositoryInterface;
use App\Repositories\Interface\UserRepositoryInterface;
use App\Repositories\Interface\ZoneRepositoryInterface;
use App\Repositories\Interface\AdminRepositoryInterface;
use App\Repositories\Interface\BrandRepositoryInterface;
use App\Repositories\Interface\OrderRepositoryInterface;
use App\Repositories\Interface\BannerRepositoryInterface;
use App\Repositories\Interface\AddressControllerInterface;
use App\Repositories\Interface\CountryRepositoryInterface;
use App\Repositories\Interface\PaymentRepositoryInterface;
use App\Repositories\Interface\ProductRepositoryInterface;
use App\Repositories\Interface\CategoryRepositoryInterface;
use App\Repositories\Interface\CurrencyRepositoryInterface;
use App\Repositories\Interface\LocationRepositoryInterface;
use App\Repositories\Interface\BrandTypeRepositoryInterface;
use App\Repositories\Interface\DashBoardRepositoryInterface;
use App\Repositories\Interface\FlashDealRepositoryInterface;
use App\Repositories\Interface\PcBuilderRepositoryInterface;
use App\Repositories\Interface\PhoneBookRepositoryInterface;
use App\Repositories\Interface\ProductStockRepositoryInterface;
use App\Repositories\Interface\GatewayConfigurationRepositoryInterface;
use App\Repositories\Interface\ProductSpecificationRepositoryInterface;
use App\Repositories\Interface\CustomerRepositoryInterface;
use App\Repositories\Interface\CustomerQuestionRepositoryInterface;
use App\Repositories\Interface\CouponRepositoryInterface;
use App\Repositories\CouponRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
        $this->app->bind(DashBoardRepositoryInterface::class, DashboardRepository::class);
        $this->app->bind(GatewayConfigurationRepositoryInterface::class, GatewayConfigurationRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
        $this->app->bind(PcBuilderRepositoryInterface::class, PcBuilderRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductSpecificationRepositoryInterface::class, ProductSpecificationRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(ZoneRepositoryInterface::class, ZoneRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(BrandTypeRepositoryInterface::class, BrandTypeRepository::class);
        $this->app->bind(TaxRepositoryInterface::class, TaxRepository::class);
        $this->app->bind(PageRepositoryInterface::class, PageRepository::class);
        $this->app->bind(FlashDealRepositoryInterface::class, FlashDealRepository::class);
        $this->app->bind(ProductStockRepositoryInterface::class, ProductStockRepository::class);
        $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);
        $this->app->bind(PhoneBookRepositoryInterface::class, PhoneBookRepository::class);
        $this->app->bind(AddressControllerInterface::class, AddressRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(CustomerQuestionRepositoryInterface::class, CustomerQuestionRepository::class);
        $this->app->bind(CouponRepositoryInterface::class, CouponRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}