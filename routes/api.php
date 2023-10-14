<?php

use App\Http\Controllers\AboutAttachmentController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasicInfoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Market\BrandController;
use App\Http\Controllers\Market\CartItemController;
use App\Http\Controllers\Market\CashPaymentController;
use App\Http\Controllers\Market\DeliveryController;
use App\Http\Controllers\Market\GuaranteeController;
use App\Http\Controllers\Market\OfflinePaymentController;
use App\Http\Controllers\Market\ProductCategoryController;
use App\Http\Controllers\Market\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Market\SmsController;
use App\Http\Controllers\Market\PostController;
use App\Http\Controllers\Market\ProductImageController;
use App\Http\Controllers\Market\ProductColorController;
use App\Http\Controllers\Market\ProductPropertyController;
use App\Http\Controllers\Market\AmazingSaleController;
use App\Http\Controllers\Market\OnlinePaymentController;
use App\Http\Controllers\Market\ProductTransactionController;
use App\Http\Controllers\Market\CommentController;
use App\Http\Controllers\Market\PostCategoryController;
use App\Http\Controllers\Market\CopanController;
use App\Http\Controllers\Market\OrderItemController;
use App\Http\Controllers\Market\OrderController;
use App\Http\Controllers\Market\PaymentController;
use App\Http\Controllers\Market\EmailController;
use App\Http\Controllers\Market\EmailFileController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Market\BannerController;
use App\Http\Controllers\Market\CategoryAttributeController;
use App\Http\Controllers\Market\CategoryValueController;
use App\Http\Controllers\Market\EmailInsertController;
use App\Http\Controllers\Market\RateController;
use App\Http\Controllers\Market\StripeController;
use App\Http\Controllers\Market\ArticleCategoryController;
use App\Http\Controllers\Market\ArticleController;
use App\Http\Controllers\Market\HelpSizeController;
use App\Http\Controllers\Market\JoinController;
use App\Http\Controllers\Market\ProductCategoryQuestionController;
use App\Http\Controllers\Market\ProductForbidenController;
use App\Http\Controllers\Market\ProductRateController;
use App\Http\Controllers\Market\ProductSocialController;
use App\Http\Controllers\Market\ProductVideoController;
use App\Http\Controllers\Market\QuestionCategoryController;
use App\Http\Controllers\Market\QuestionController;
use App\Http\Controllers\Market\RateAverageController;
use App\Http\Controllers\Market\UserFavoritesProductController;
use App\Http\Controllers\Market\WalletController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProvinceController;
use App\Http\Resources\userFavoritesProduct\UserFavoritesProductResource;
use App\Models\Market\ProductSocial;
use App\Models\Market\QuestionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/mobile', function (Request $request) {
    $mobile = "09387589696";
    $programmer = "mehrdad ebrahimi";
    return response()->json(['programmer' => $programmer, 'mobile' => $mobile]);
});

//version v1
Route::prefix('v1')->group(function () {


    Route::prefix('auth')->group(function () {
        //        Route::get('login', function () {
        //            return redirect('/');
        //        })->name('login');
        Route::post('/sendCodeVerificationWithEmail', [AuthController::class, 'sendCodeVerificationWithEmail']);
        Route::post('/verifyEmail', [AuthController::class, 'verifyEmail']);
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::prefix('otp')->group(function () {
            Route::post('/', [AuthController::class, 'otp'])->name('otp');
            Route::post('/verify', [AuthController::class, 'verifyMobile']);
            //   Route::get('/verify', [AuthController::class, 'verifyMobile']);
        });
        Route::post('register', [AuthController::class, 'register']);
    });


    Route::middleware('auth:sanctum')->group(function () {

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/store', [UserController::class, 'store']);
            Route::get('/show/{id}', [UserController::class, 'show']);
            Route::patch('/update/{id}', [UserController::class, 'update']);
            Route::delete('/delete/{id}', [UserController::class, 'destroy']);


            Route::post('/assign-role', [UserController::class, 'assignRole']);
            Route::post('/has-role', [UserController::class, 'hasRole']);
            Route::post('/has-any-role', [UserController::class, 'hasAnyRole']);
            Route::post('/has-all-roles', [UserController::class, 'hasAllRoles']);
            Route::post('/remove-role', [UserController::class, 'removeRole']);
            Route::post('/revoke-permission-from-role', [UserController::class, 'revokePermissionFromRole']);
            Route::post('/role/permissions', [UserController::class, 'permissionsForRole']);



            Route::post('/assign-permission', [UserController::class, 'assignPermission']);
            Route::post('/assign-permission-to-role', [UserController::class, 'assignPermissionToRole']);
            Route::post('/has-direct-permission', [UserController::class, 'hasDirectPermission']);
            Route::post('/has-all-direct-permissions', [UserController::class, 'hasAllDirectPermissions']);
            Route::post('/has-any-direct-permissions', [UserController::class, 'hasAnyDirectPermission']);
            Route::post('/get-direct-permissions', [UserController::class, 'getDirectPermissions']);


            Route::group(['prefix' => 'role'], function () {
                Route::get('/', [RoleController::class, 'index']);
                Route::post('/store', [RoleController::class, 'store']);
                Route::get('/show/{id}', [RoleController::class, 'show']);
                Route::patch('/update/{id}', [RoleController::class, 'update']);
                Route::delete('/delete/{id}', [RoleController::class, 'destroy']);
            });
            Route::group(['prefix' => 'permission'], function () {
                Route::get('/', [PermissionController::class, 'index']);
                Route::post('/store', [PermissionController::class, 'store']);
                Route::get('/show/{id}', [PermissionController::class, 'show']);
                Route::patch('/update/{id}', [PermissionController::class, 'update']);
                Route::delete('/delete/{id}', [PermissionController::class, 'destroy']);
            });
        });


        Route::group(['prefix' => 'province'], function () {
            Route::get('/', [ProvinceController::class, 'index']);
            Route::post('/store', [ProvinceController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ProvinceController::class, 'show']);
            Route::patch('/update/{id}', [ProvinceController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ProvinceController::class, 'destroy']); //->middleware('is_admin')
        });

        Route::group(['prefix' => 'emailInsert'], function () {
            Route::get('/', [EmailInsertController::class, 'index']);
            Route::post('/store', [EmailInsertController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [EmailInsertController::class, 'show']);
            Route::patch('/update/{id}', [EmailInsertController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [EmailInsertController::class, 'destroy']); //->middleware('is_admin')
        });


        Route::group(['prefix' => 'city'], function () {
            Route::get('/', [CityController::class, 'index']);
            Route::post('/store', [CityController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [CityController::class, 'show']);
            Route::patch('/update/{id}', [CityController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [CityController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'address'], function () {
            Route::get('/', [AddressController::class, 'index']);
            Route::post('/store', [AddressController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [AddressController::class, 'show']);
            Route::patch('/update/{id}', [AddressController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [AddressController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'otp'], function () {
            Route::get('/', [OtpController::class, 'index']);
            //            Route::post('/store', [OtpController::class, 'store']) ; //->middleware('is_admin')
            Route::get('/show/{id}', [OtpController::class, 'show']);
            //            Route::patch('/update/{id}', [OtpController::class, 'update']) ; //->middleware('is_admin')
            Route::delete('/delete/{id}', [OtpController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'brand'], function () {
            Route::get('/', [BrandController::class, 'index']);
            Route::post('/store', [BrandController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [BrandController::class, 'show']);
            Route::post('/update/{id}', [BrandController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [BrandController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'cart-item'], function () {
            Route::get('/', [CartItemController::class, 'index']);
            Route::post('/store', [CartItemController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [CartItemController::class, 'show']);
            Route::patch('/update/{id}', [CartItemController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [CartItemController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'cash-payment'], function () {
            Route::get('/', [CashPaymentController::class, 'index']);
            Route::post('/store', [CashPaymentController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [CashPaymentController::class, 'show']);
            Route::patch('/update/{id}', [CashPaymentController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [CashPaymentController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'online-payment'], function () {
            Route::get('/', [OnlinePaymentController::class, 'index']);
            Route::post('/store', [OnlinePaymentController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [OnlinePaymentController::class, 'show']);
            Route::patch('/update/{id}', [OnlinePaymentController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [OnlinePaymentController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'delivery'], function () {
            Route::get('/', [DeliveryController::class, 'index']);
            Route::post('/store', [DeliveryController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [DeliveryController::class, 'show']);
            Route::patch('/update/{id}', [DeliveryController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [DeliveryController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'guarantee'], function () {
            Route::get('/', [GuaranteeController::class, 'index']);
            Route::post('/store', [GuaranteeController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [GuaranteeController::class, 'show']);
            Route::patch('/update/{id}', [GuaranteeController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [GuaranteeController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'product-category-question'], function () {
            Route::get('/', [ProductCategoryQuestionController::class, 'index']);
            Route::post('/store', [ProductCategoryQuestionController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ProductCategoryQuestionController::class, 'show']);
            Route::patch('/update/{id}', [ProductCategoryQuestionController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ProductCategoryQuestionController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'product-rate'], function () {
            Route::get('/', [ProductRateController::class, 'index']);
            Route::post('/store', [ProductRateController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ProductRateController::class, 'show']);
            Route::patch('/update/{id}', [ProductRateController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ProductRateController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'product-rate-average'], function () {
            Route::get('/', [RateAverageController::class, 'index']);
            Route::post('/store', [RateAverageController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [RateAverageController::class, 'show']);
          //  Route::patch('/update/{id}', [RateAverageController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [RateAverageController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'product-forbiden'], function () {
            Route::get('/', [ProductForbidenController::class, 'index']);
            Route::post('/store', [ProductForbidenController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ProductForbidenController::class, 'show']);
            Route::patch('/update/{id}', [ProductForbidenController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ProductForbidenController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'offline-payment'], function () {
            Route::get('/', [OfflinePaymentController::class, 'index']);
            Route::post('/store', [OfflinePaymentController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [OfflinePaymentController::class, 'show']);
            Route::patch('/update/{id}', [OfflinePaymentController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [OfflinePaymentController::class, 'destroy']);  //->middleware('is_admin')
        });

        Route::group(['prefix' => 'help-size'], function () {
            Route::get('/', [HelpSizeController::class, 'index']);
            Route::post('/store', [HelpSizeController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [HelpSizeController::class, 'show']);
            Route::patch('/update/{id}', [HelpSizeController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [HelpSizeController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'product-category'], function () {
            Route::get('/', [ProductCategoryController::class, 'index']);
            Route::post('/store', [ProductCategoryController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ProductCategoryController::class, 'show']);
            Route::post('/update/{id}', [ProductCategoryController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ProductCategoryController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'product'], function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::post('/store', [ProductController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ProductController::class, 'show'])->name("product.link");
            Route::post('/update/{id}', [ProductController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ProductController::class, 'destroy']);  //->middleware('is_admin')
            Route::post('/storeAverageRate/{id}', [ProductController::class, 'storeAverageRate']); //->middleware('is_admin')
            Route::get('/show/link/{id}', [ProductController::class, 'showLink']); //->middleware('is_admin')

        });


        Route::group(['prefix' => 'rate'], function () {
            Route::get('/', [RateController::class, 'index']);
            Route::post('/store', [RateController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [RateController::class, 'show']);
            Route::patch('/update/{id}', [RateController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [RateController::class, 'destroy']);  //->middleware('is_admin')

        });



        Route::group(['prefix' => 'category-attribute'], function () {
            Route::get('/', [CategoryAttributeController::class, 'index']);
            Route::post('/store', [CategoryAttributeController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [CategoryAttributeController::class, 'show']);
            Route::patch('/update/{id}', [CategoryAttributeController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [CategoryAttributeController::class, 'destroy']);  //->middleware('is_admin')

        });


        Route::group(['prefix' => 'basic-info'], function () {
            Route::get('/', [BasicInfoController::class, 'index']);
            Route::post('/store', [BasicInfoController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [BasicInfoController::class, 'show']);
            Route::patch('/update/{id}', [BasicInfoController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [BasicInfoController::class, 'destroy']);  //->middleware('is_admin')

        });


        Route::group(['prefix' => 'contact-us'], function () {
            Route::get('/', [ContactController::class, 'index']);
            Route::post('/store', [ContactController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ContactController::class, 'show']);
            Route::patch('/update/{id}', [ContactController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ContactController::class, 'destroy']);  //->middleware('is_admin')

        });

        Route::group(['prefix' => 'about-us'], function () {
            Route::get('/', [AboutController::class, 'index']);
            Route::post('/store', [AboutController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [AboutController::class, 'show']);
            Route::post('/update/{id}', [AboutController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [AboutController::class, 'destroy']);  //->middleware('is_admin')

        });


        Route::group(['prefix' => 'about-attachment'], function () {
            Route::get('/', [AboutAttachmentController::class, 'index']);
            Route::post('/store', [AboutAttachmentController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [AboutAttachmentController::class, 'show']);
            Route::post('/update/{id}', [AboutAttachmentController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [AboutAttachmentController::class, 'destroy']);  //->middleware('is_admin')

        });

        Route::group(['prefix' => 'join-us'], function () {
            Route::get('/', [JoinController::class, 'index']);
            Route::post('/store', [JoinController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [JoinController::class, 'show']);
            Route::post('/update/{id}', [JoinController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [JoinController::class, 'destroy']);  //->middleware('is_admin')

        });

        Route::group(['prefix' => 'article-category'], function () {
            Route::get('/', [ArticleCategoryController::class, 'index']);
            Route::post('/store', [ArticleCategoryController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ArticleCategoryController::class, 'show']);
            Route::patch('/update/{id}', [ArticleCategoryController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ArticleCategoryController::class, 'destroy']);  //->middleware('is_admin')

        });


        Route::group(['prefix' => 'article'], function () {
            Route::get('/', [ArticleController::class, 'index']);
            Route::post('/store', [ArticleController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ArticleController::class, 'show']);
            Route::post('/update/{id}', [ArticleController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ArticleController::class, 'destroy']);  //->middleware('is_admin')

        });


        Route::group(['prefix' => 'news'], function () {
            Route::get('/', [NewsController::class, 'index']);
            Route::post('/store', [NewsController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [NewsController::class, 'show']);
            Route::patch('/update/{id}', [NewsController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [NewsController::class, 'destroy']);  //->middleware('is_admin')

        });


        Route::group(['prefix' => 'condition'], function () {
            Route::get('/', [ConditionController::class, 'index']);
            Route::post('/store', [ConditionController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ConditionController::class, 'show']);
            Route::post('/update/{id}', [ConditionController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ConditionController::class, 'destroy']);  //->middleware('is_admin')

        });


        Route::group(['prefix' => 'product-social'], function () {
            Route::get('/', [ProductSocialController::class, 'index']);
            Route::post('/store', [ProductSocialController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ProductSocialController::class, 'show']);
            Route::post('/update/{id}', [ProductSocialController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ProductSocialController::class, 'destroy']);  //->middleware('is_admin')

        });


        Route::group(['prefix' => 'product-video'], function () {
            Route::get('/', [ProductVideoController::class, 'index']);
            Route::post('/store', [ProductVideoController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ProductVideoController::class, 'show']);
            Route::post('/update/{id}', [ProductVideoController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ProductVideoController::class, 'destroy']);  //->middleware('is_admin')

        });




        Route::group(['prefix' => 'category-value'], function () {
            Route::get('/', [CategoryValueController::class, 'index']);
            Route::post('/store', [CategoryValueController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [CategoryValueController::class, 'show']);
            Route::patch('/update/{id}', [CategoryValueController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [CategoryValueController::class, 'destroy']);  //->middleware('is_admin')

        });

        Route::group(['prefix' => 'user_favorites_product'], function () {
            Route::get('/', [UserFavoritesProductController::class, 'index']);
            Route::post('/store/{id}', [UserFavoritesProductController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [UserFavoritesProductController::class, 'show']);
          //  Route::patch('/update/{id}', [UserFavoritesProductController::class, 'update']); //->middleware('is_admin')
            Route::post('/delete/{id}', [UserFavoritesProductController::class, 'destroy']);  //->middleware('is_admin')

        });


        Route::group(['prefix' => 'question-category'], function () {
            Route::get('/', [QuestionCategoryController::class, 'index']);
            Route::post('/store', [QuestionCategoryController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [QuestionCategoryController::class, 'show']);
            Route::patch('/update/{id}', [QuestionCategoryController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [QuestionCategoryController::class, 'destroy']);  //->middleware('is_admin')

        });

        Route::group(['prefix' => 'question'], function () {
            Route::get('/', [QuestionController::class, 'index']);
            Route::post('/store', [QuestionController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [QuestionController::class, 'show']);
            Route::patch('/update/{id}', [QuestionController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [QuestionController::class, 'destroy']);  //->middleware('is_admin')
            Route::post('/help/{id}', [QuestionController::class, 'isHelpQuestion']);  

        });


        Route::group(['prefix' => 'wallet'], function () {
            Route::get('/', [WalletController::class, 'index']);
            Route::post('/store', [WalletController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [WalletController::class, 'show']);
            Route::post('/increse/{id}', [WalletController::class, 'walletIncrese']);
            Route::post('/decrese/{id}', [WalletController::class, 'walletDecrese']);
            
            Route::patch('/update/{id}', [WalletController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [WalletController::class, 'destroy']);  //->middleware('is_admin')

        });




        Route::group(['prefix' => 'banner'], function () {
            Route::get('/', [BannerController::class, 'index']);
            Route::post('/store', [BannerController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [BannerController::class, 'show']);
            Route::post('/update/{id}', [BannerController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [BannerController::class, 'destroy']);  //->middleware('is_admin')
            
        });


     



        Route::group(['prefix' => 'product-image'], function () {
            Route::get('/', [ProductImageController::class, 'index']);
            Route::post('/store', [ProductImageController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ProductImageController::class, 'show']);
            Route::post('/update/{id}', [ProductImageController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ProductImageController::class, 'destroy']);  //->middleware('is_admin')
        });

        Route::group(['prefix' => 'product-color'], function () {
            Route::get('/', [ProductColorController::class, 'index']);
            Route::post('/store', [ProductColorController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ProductColorController::class, 'show']);
            Route::patch('/update/{id}', [ProductColorController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ProductColorController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'product-property'], function () {
            Route::get('/', [ProductPropertyController::class, 'index']);
            Route::post('/store', [ProductPropertyController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [ProductPropertyController::class, 'show']);
            Route::patch('/update/{id}', [ProductPropertyController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ProductPropertyController::class, 'destroy']);  //->middleware('is_admin')
        });

        Route::group(['prefix' => 'payment'], function () {
            Route::get('/', [PaymentController::class, 'index']);
            Route::post('/store', [PaymentController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [PaymentController::class, 'show']);
            Route::patch('/update/{id}', [PaymentController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [PaymentController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'order'], function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::post('/store', [OrderController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [OrderController::class, 'show']);
            Route::patch('/update/{id}', [OrderController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [OrderController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'order-item'], function () {
            Route::get('/', [OrderItemController::class, 'index']);
            Route::post('/store', [OrderItemController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [OrderItemController::class, 'show']);
            Route::patch('/update/{id}', [OrderItemController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [OrderItemController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'transaction'], function () {
            Route::get('/', [ProductTransactionController::class, 'index']);
            Route::post('/verify', [ProductTransactionController::class, 'verify']); //->middleware('is_admin')
            Route::get('/callback', [ProductTransactionController::class, 'callback']); //->middleware('is_admin')
            Route::get('/show/{id}', [ProductTransactionController::class, 'show']);
            Route::patch('/update/{id}', [ProductTransactionController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [ProductTransactionController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'stripe-transaction'], function () {
            Route::get('/', [StripeController::class, 'index']);
            Route::post('/checkout', [StripeController::class, 'checkout']); //->middleware('is_admin')
            Route::post('/webhook',[StripeController::class,'webhook'])->name('checkout.webhook');
            Route::get('/show/{id}', [StripeController::class, 'show']);
            Route::patch('/update/{id}', [StripeController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [StripeController::class, 'destroy']);  //->middleware('is_admin')
        });



        Route::group(['prefix' => 'amazing-sale'], function () {
            Route::get('/', [AmazingSaleController::class, 'index']);
            Route::post('/store', [AmazingSaleController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [AmazingSaleController::class, 'show']);
            Route::patch('/update/{id}', [AmazingSaleController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [AmazingSaleController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'copan'], function () {
            Route::get('/', [CopanController::class, 'index']);
            Route::post('/store', [CopanController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [CopanController::class, 'show']);
            Route::patch('/update/{id}', [CopanController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [CopanController::class, 'destroy']);  //->middleware('is_admin')
        });

        Route::group(['prefix' => 'post-category'], function () {
            Route::get('/', [PostCategoryController::class, 'index']);
            Route::post('/store', [PostCategoryController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [PostCategoryController::class, 'show']);
            Route::patch('/update/{id}', [PostCategoryController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [PostCategoryController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'post'], function () {
            Route::get('/', [PostController::class, 'index']);
            Route::post('/store', [PostController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [PostController::class, 'show']);
            Route::post('/update/{id}', [PostController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [PostController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'comment'], function () {
            Route::get('/', [commentController::class, 'index']);
            Route::post('/store', [commentController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [commentController::class, 'show']);
            Route::post('/update/{id}', [commentController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [commentController::class, 'destroy']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'sms'], function () {
            Route::get('/', [SmsController::class, 'index']);
            Route::post('/store', [SmsController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [SmsController::class, 'show']);
            Route::patch('/update/{id}', [SmsController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [SmsController::class, 'destroy']);  //->middleware('is_admin')
            Route::get('/send-sms/{id}', [SmsController::class, 'sendSms']);  //->middleware('is_admin')
        });


        Route::group(['prefix' => 'email'], function () {
            Route::get('/', [EmailController::class, 'index']);
            Route::post('/store', [EmailController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [EmailController::class, 'show']);
            Route::post('/update/{id}', [EmailController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [EmailController::class, 'destroy']);  //->middleware('is_admin')
            Route::get('/send-email/{id}', [EmailController::class, 'sendEmailForAllUsers']);
            Route::post('/send-order-payment-email', [EmailController::class, 'sendOrderPaymentEmail']);
        });


        Route::group(['prefix' => 'email-file'], function () {
            Route::get('/', [EmailFileController::class, 'index']);
            Route::post('/store', [EmailFileController::class, 'store']); //->middleware('is_admin')
            Route::get('/show/{id}', [EmailFileController::class, 'show']);
            Route::post('/update/{id}', [EmailFileController::class, 'update']); //->middleware('is_admin')
            Route::delete('/delete/{id}', [EmailFileController::class, 'destroy']);  //->middleware('is_admin')
        });
    });
    Route::get('/transaction/callback/{id}', [ProductTransactionController::class, 'callback']); //->middleware('is_admin') 


});
