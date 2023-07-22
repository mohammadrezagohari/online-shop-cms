<?php

namespace App\Providers;

use App\Repositories\MySQL\AmazingSaleRepository\AmazingSaleRepository;
use App\Repositories\MySQL\AmazingSaleRepository\InterfaceAmazingSaleRepository;
use App\Repositories\MySQL\IBaseRepository;
use App\Repositories\MySQL\BaseRepository;
use App\Repositories\MySQL\AddressRepository\AddressRepository;
use App\Repositories\MySQL\AddressRepository\InterfaceAddressRepository;
use App\Repositories\MySQL\BrandRepository\BrandRepository;
use App\Repositories\MySQL\BrandRepository\InterfaceBrandRepository;
use App\Repositories\MySQL\CartItemRepository\CartItemRepository;
use App\Repositories\MySQL\CartItemRepository\InterfaceCartItemRepository;
use App\Repositories\MySQL\CashPaymentRepository\CashPaymentRepository;
use App\Repositories\MySQL\CashPaymentRepository\InterfaceCashPaymentRepository;
use App\Repositories\MySQL\CityRepository\CityRepository;
use App\Repositories\MySQL\CityRepository\InterfaceCityRepository;
use App\Repositories\MySQL\DeliveryRepository\DeliveryRepository;
use App\Repositories\MySQL\DeliveryRepository\InterfaceDeliveryRepository;
use App\Repositories\MySQL\GuaranteeRepository\GuaranteeRepository;
use App\Repositories\MySQL\GuaranteeRepository\InterfaceGuaranteeRepository;
use App\Repositories\MySQL\OfflinePaymentRepository\InterfaceOfflinePaymentRepository;
use App\Repositories\MySQL\OfflinePaymentRepository\OfflinePaymentRepository;
use App\Repositories\MySQL\OnlinePaymentRepository\InterfaceOnlinePaymentRepository;
use App\Repositories\MySQL\OnlinePaymentRepository\OnlinePaymentRepository;
use App\Repositories\MySQL\OrderItemRepository\InterfaceOrderItemRepository;
use App\Repositories\MySQL\OrderItemRepository\OrderItemRepository;
use App\Repositories\MySQL\OrderRepository\InterfaceOrderRepository;
use App\Repositories\MySQL\OrderRepository\OrderRepository;
use App\Repositories\MySQL\OtpRepository\InterfaceOtpRepository;
use App\Repositories\MySQL\OtpRepository\OtpRepository;
use App\Repositories\MySQL\PaymentRepository\InterfacePaymentRepository;
use App\Repositories\MySQL\PaymentRepository\PaymentRepository;
use App\Repositories\MySQL\ProductCategoryRepository\InterfaceProductCategoryRepository;
use App\Repositories\MySQL\ProductCategoryRepository\ProductCategoryRepository;
use App\Repositories\MySQL\ProductColorRepository\InterfaceProductColorRepository;
use App\Repositories\MySQL\ProductColorRepository\ProductColorRepository;
use App\Repositories\MySQL\ProductImageRepository\InterfaceProductImageRepository;
use App\Repositories\MySQL\ProductImageRepository\ProductImageRepository;
use App\Repositories\MySQL\ProductPropertyRepository\InterfaceProductPropertyRepository;
use App\Repositories\MySQL\ProductPropertyRepository\ProductPropertyRepository;
use App\Repositories\MySQL\ProductRepository\InterfaceProductRepository;
use App\Repositories\MySQL\ProductRepository\ProductRepository;
use App\Repositories\MySQL\ProvinceRepository\InterfaceProvinceRepository;
use App\Repositories\MySQL\ProvinceRepository\ProvinceRepository;
use App\Repositories\MySQL\TransactionRepository\InterfaceTransactionRepository;
use App\Repositories\MySQL\TransactionRepository\TransactionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IBaseRepository::class, BaseRepository::class);
        $this->app->bind(InterfaceAddressRepository::class, AddressRepository::class);
        $this->app->bind(InterfaceBrandRepository::class, BrandRepository::class);
        $this->app->bind(InterfaceCartItemRepository::class, CartItemRepository::class);
        $this->app->bind(InterfaceCashPaymentRepository::class, CashPaymentRepository::class);
        $this->app->bind(InterfacecityRepository::class, CityRepository::class);
        $this->app->bind(InterfaceDeliveryRepository::class, DeliveryRepository::class);
        $this->app->bind(InterfaceGuaranteeRepository::class, GuaranteeRepository::class);
        $this->app->bind(InterfaceOfflinePaymentRepository::class, OfflinePaymentRepository::class);
        $this->app->bind(InterfaceOnlinePaymentRepository::class, OnlinePaymentRepository::class);
        $this->app->bind(InterfaceOrderItemRepository::class, OrderItemRepository::class);
        $this->app->bind(InterfaceOrderRepository::class, OrderRepository::class);
        $this->app->bind(InterfaceOtpRepository::class, OtpRepository::class);
        $this->app->bind(InterfacePaymentRepository::class, PaymentRepository::class);
        $this->app->bind(InterfaceProductCategoryRepository::class, ProductCategoryRepository::class);
        $this->app->bind(InterfaceProductColorRepository::class, ProductColorRepository::class);
        $this->app->bind(InterfaceProductImageRepository::class, ProductImageRepository::class);
        $this->app->bind(InterfaceProductPropertyRepository::class, ProductPropertyRepository::class);
        $this->app->bind(InterfaceProvinceRepository::class, ProvinceRepository::class);
        $this->app->bind(InterfaceTransactionRepository::class, TransactionRepository::class);
        $this->app->bind(InterfaceProductRepository::class,ProductRepository::class);
        $this->app->bind(InterfaceAmazingSaleRepository::class,AmazingSaleRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
