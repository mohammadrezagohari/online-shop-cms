<?php

namespace App\Providers;


use App\Repositories\MySQL\AboutAttachmentRepository\AboutAttachmentRepository;
use App\Repositories\MySQL\AboutAttachmentRepository\InterfaceAboutAttachmentRepository;
use App\Repositories\MySQL\AboutRepository\AboutRepository;
use App\Repositories\MySQL\AboutRepository\InterfaceAboutRepository;
use App\Repositories\MySQL\CommentRepository\CommentRepository;
use App\Repositories\MySQL\CommentRepository\InterfaceCommentRepository;
use App\Repositories\MySQL\CopanRepository\CopanRepository;
use App\Repositories\MySQL\AmazingSaleRepository\AmazingSaleRepository;
use App\Repositories\MySQL\AmazingSaleRepository\InterfaceAmazingSaleRepository;
use App\Repositories\MySQL\CopanRepository\InterfaceCopanRepository;
use App\Repositories\MySQL\EmailFileRepository\EmailFileRepository;
use App\Repositories\MySQL\EmailFileRepository\InterfaceEmailFileRepository;
use App\Repositories\MySQL\EmailRepository\EmailRepository;
use App\Repositories\MySQL\EmailRepository\InterfaceEmailRepository;
use App\Repositories\MySQL\IBaseRepository;
use App\Repositories\MySQL\BaseRepository;
use App\Repositories\MySQL\AddressRepository\AddressRepository;
use App\Repositories\MySQL\AddressRepository\InterfaceAddressRepository;
use App\Repositories\MySQL\ArticleCategoryRepository\ArticleCategoryRepository;
use App\Repositories\MySQL\ArticleCategoryRepository\InterfaceArticleCategoryRepository;
use App\Repositories\MySQL\ArticleRepository\ArticleRepository;
use App\Repositories\MySQL\ArticleRepository\InterfaceArticleRepository;
use App\Repositories\MySQL\BannerRepository\BannerRepository;
use App\Repositories\MySQL\BannerRepository\InterfaceBannerRepository;
use App\Repositories\MySQL\BasicInfoRepository\BasicInfoRepository;
use App\Repositories\MySQL\BasicInfoRepository\InterfaceBasicInfoRepository;
use App\Repositories\MySQL\BrandRepository\BrandRepository;
use App\Repositories\MySQL\BrandRepository\InterfaceBrandRepository;
use App\Repositories\MySQL\CartItemRepository\CartItemRepository;
use App\Repositories\MySQL\CartItemRepository\InterfaceCartItemRepository;
use App\Repositories\MySQL\CashPaymentRepository\CashPaymentRepository;
use App\Repositories\MySQL\CashPaymentRepository\InterfaceCashPaymentRepository;
use App\Repositories\MySQL\CategoryAttributeRepository\CategoryAttributeRepository;
use App\Repositories\MySQL\CategoryAttributeRepository\InterfaceCategoryAttributeRepository;
use App\Repositories\MySQL\CategoryValueRepository\CategoryValueRepository;
use App\Repositories\MySQL\CategoryValueRepository\InterfaceCategoryValueRepository;
use App\Repositories\MySQL\CityRepository\CityRepository;
use App\Repositories\MySQL\CityRepository\InterfaceCityRepository;
use App\Repositories\MySQL\ConditionRepository\ConditionRepository;
use App\Repositories\MySQL\ConditionRepository\InterfaceConditionRepository;
use App\Repositories\MySQL\ContactRepository\ContactRepository;
use App\Repositories\MySQL\ContactRepository\InterfaceContactRepository;
use App\Repositories\MySQL\DeliveryRepository\DeliveryRepository;
use App\Repositories\MySQL\DeliveryRepository\InterfaceDeliveryRepository;
use App\Repositories\MySQL\EmailInsertRepository\EmailInsertRepository;
use App\Repositories\MySQL\EmailInsertRepository\InterfaceEmailInsertRepository;
use App\Repositories\MySQL\GuaranteeRepository\GuaranteeRepository;
use App\Repositories\MySQL\GuaranteeRepository\InterfaceGuaranteeRepository;
use App\Repositories\MySQL\HelpSizeRepository\HelpSizeRepository;
use App\Repositories\MySQL\HelpSizeRepository\InterfaceHelpSizeRepository;
use App\Repositories\MySQL\JoinRepository\InterfaceJoinRepository;
use App\Repositories\MySQL\JoinRepository\JoinRepository;
use App\Repositories\MySQL\NewsRepository\InterfaceNewsRepository;
use App\Repositories\MySQL\NewsRepository\NewsRepository;
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
use App\Repositories\MySQL\PermissionRepository\InterfacePermissionRepository;
use App\Repositories\MySQL\PermissionRepository\PermissionRepository;
use App\Repositories\MySQL\PostCategoryRepository\PostCategoryRepository;
use App\Repositories\MySQL\PostCategoryRepository\InterfacePostCategoryRepository;
use App\Repositories\MySQL\PostRepository\InterfacePostRepository;
use App\Repositories\MySQL\PostRepository\PostRepository;
use App\Repositories\MySQL\ProductCategoryQuestionRepository\InterfaceProductCategoryQuestionRepository;
use App\Repositories\MySQL\ProductCategoryQuestionRepository\ProductCategoryQuestionRepository;
use App\Repositories\MySQL\ProductCategoryRepository\InterfaceProductCategoryRepository;
use App\Repositories\MySQL\ProductCategoryRepository\ProductCategoryRepository;
use App\Repositories\MySQL\ProductColorRepository\InterfaceProductColorRepository;
use App\Repositories\MySQL\ProductColorRepository\ProductColorRepository;
use App\Repositories\MySQL\ProductForbidenRepository\InterfaceProductForbidenRepository ;
use App\Repositories\MySQL\ProductForbidenRepository\ProductForbidenRepository;
use App\Repositories\MySQL\ProductImageRepository\InterfaceProductImageRepository;
use App\Repositories\MySQL\ProductImageRepository\ProductImageRepository;
use App\Repositories\MySQL\ProductPropertyRepository\InterfaceProductPropertyRepository;
use App\Repositories\MySQL\ProductPropertyRepository\ProductPropertyRepository;
use App\Repositories\MySQL\ProductRateRepository\InterfaceProductRateRepository;
use App\Repositories\MySQL\ProductRateRepository\ProductRateRepository;
use App\Repositories\MySQL\ProductRepository\InterfaceProductRepository;
use App\Repositories\MySQL\ProductRepository\ProductRepository;
use App\Repositories\MySQL\ProductSocialRepository\InterfaceProductSocialRepository;
use App\Repositories\MySQL\ProductSocialRepository\ProductSocialRepository;
use App\Repositories\MySQL\ProductVideoRepository\InterfaceProductVideoRepository;
use App\Repositories\MySQL\ProductVideoRepository\ProductVideoRepository;
use App\Repositories\MySQL\ProvinceRepository\InterfaceProvinceRepository;
use App\Repositories\MySQL\ProvinceRepository\ProvinceRepository;
use App\Repositories\MySQL\QuestionCategoryRepository\InterfaceQuestionCategoryRepository;
use App\Repositories\MySQL\QuestionCategoryRepository\QuestionCategoryRepository;
use App\Repositories\MySQL\QuestionRepository\InterfaceQuestionRepository;
use App\Repositories\MySQL\QuestionRepository\QuestionRepository;
use App\Repositories\MySQL\RateAverageRepository\RateAverageRepository;
use App\Repositories\MySQL\RateAverageRepository\InterfaceRateAverageRepository;
use App\Repositories\MySQL\RateRepository\InterfaceRateRepository;
use App\Repositories\MySQL\RateRepository\RateRepository;
use App\Repositories\MySQL\RoleRepository\InterfaceRoleRepository;
use App\Repositories\MySQL\RoleRepository\RoleRepository;
use App\Repositories\MySQL\SmsRepository\InterfaceSmsRepository;
use App\Repositories\MySQL\SmsRepository\SmsRepository;
use App\Repositories\MySQL\StripeTransactionRepository\InterfaceStripeTransactionRepository;
use App\Repositories\MySQL\TransactionRepository\InterfaceTransactionRepository;
use App\Repositories\MySQL\TransactionRepository\TransactionRepository;
use App\Repositories\MySQL\UserRepository\InterfaceUserRepository;
use App\Repositories\MySQL\UserRepository\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\MySQL\StripeTransactionRepository\StripeTransactionRepository;
use App\Repositories\MySQL\WalletRepository\InterfaceWalletRepository;
use App\Repositories\MySQL\WalletRepository\WalletRepository;

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
        $this->app->bind(InterfaceCopanRepository::class,CopanRepository::class);
        $this->app->bind(InterfacePostCategoryRepository::class,PostCategoryRepository::class);
        $this->app->bind(InterfacePostRepository::class,PostRepository::class);
        $this->app->bind(InterfaceCommentRepository::class,CommentRepository::class);
        $this->app->bind(InterfaceSmsRepository::class,SmsRepository::class);
        $this->app->bind(InterfaceEmailRepository::class,EmailRepository::class);
        $this->app->bind(InterfaceEmailFileRepository::class,EmailFileRepository::class);
        $this->app->bind(InterfaceUserRepository::class,UserRepository::class);
        $this->app->bind(InterfacePermissionRepository::class,PermissionRepository::class);
        $this->app->bind(InterfaceRoleRepository::class,RoleRepository::class);
        $this->app->bind(InterfaceStripeTransactionRepository::class,StripeTransactionRepository::class);
        $this->app->bind(InterfaceBannerRepository::class,BannerRepository::class);
        $this->app->bind(InterfaceEmailInsertRepository::class,EmailInsertRepository::class);
        $this->app->bind(InterfaceRateRepository::class,RateRepository::class);
        $this->app->bind(InterfaceCategoryAttributeRepository::class,CategoryAttributeRepository::class);
        $this->app->bind(InterfaceCategoryValueRepository::class,CategoryValueRepository::class);
        $this->app->bind(InterfaceBasicInfoRepository::class,BasicInfoRepository::class);
        $this->app->bind(InterfaceContactRepository::class,ContactRepository::class);
        $this->app->bind(InterfaceAboutRepository::class,AboutRepository::class);
        $this->app->bind(InterfaceAboutAttachmentRepository::class,AboutAttachmentRepository::class);
        $this->app->bind(InterfaceArticleCategoryRepository::class,ArticleCategoryRepository::class);
        $this->app->bind(InterfaceArticleRepository::class,ArticleRepository::class);
        $this->app->bind(InterfaceNewsRepository::class,NewsRepository::class);
        $this->app->bind(InterfaceConditionRepository::class,ConditionRepository::class);
        $this->app->bind(InterfaceProductSocialRepository::class,ProductSocialRepository::class);
        $this->app->bind(InterfaceProductVideoRepository::class,ProductVideoRepository::class);
        $this->app->bind(InterfaceWalletRepository::class,WalletRepository::class);
        $this->app->bind(InterfaceQuestionCategoryRepository::class,QuestionCategoryRepository::class);
        $this->app->bind(InterfaceQuestionRepository::class,QuestionRepository::class);
        $this->app->bind(InterfaceJoinRepository::class,JoinRepository::class);
        $this->app->bind(InterfaceProductCategoryQuestionRepository::class,ProductCategoryQuestionRepository::class);
        $this->app->bind(InterfaceProductRateRepository::class,ProductRateRepository::class);
        $this->app->bind(InterfaceRateAverageRepository::class,RateAverageRepository::class);
        $this->app->bind(InterfaceHelpSizeRepository::class,HelpSizeRepository::class);
        $this->app->bind(InterfaceProductForbidenRepository::class,ProductForbidenRepository::class);
    }

    /**
     * Bootstrap services
     */
    public function boot(): void
    {
        //
    }
}
