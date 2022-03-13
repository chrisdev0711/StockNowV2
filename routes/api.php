<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\Api\ZoneController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\SellableController;
use App\Http\Controllers\Api\SiteZonesController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\SiteProductsController;
use App\Http\Controllers\Api\ProductSitesController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\HistoricalPriceController;
use App\Http\Controllers\Api\SupplierProductsController;
use App\Http\Controllers\Api\ProductSellablesController;
use App\Http\Controllers\Api\SellableProductsController;
use App\Http\Controllers\Api\ProductCategoryProductsController;
use App\Http\Controllers\Api\ProductHistoricalPricesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('sites', SiteController::class);

        // Site Zones
        Route::get('/sites/{site}/zones', [
            SiteZonesController::class,
            'index',
        ])->name('sites.zones.index');
        Route::post('/sites/{site}/zones', [
            SiteZonesController::class,
            'store',
        ])->name('sites.zones.store');

        // Site Products
        Route::get('/sites/{site}/products', [
            SiteProductsController::class,
            'index',
        ])->name('sites.products.index');
        Route::post('/sites/{site}/products/{product}', [
            SiteProductsController::class,
            'store',
        ])->name('sites.products.store');
        Route::delete('/sites/{site}/products/{product}', [
            SiteProductsController::class,
            'destroy',
        ])->name('sites.products.destroy');

        Route::apiResource('zones', ZoneController::class);

        Route::apiResource(
            'product-categories',
            ProductCategoryController::class
        );

        // ProductCategory Products
        Route::get('/product-categories/{productCategory}/products', [
            ProductCategoryProductsController::class,
            'index',
        ])->name('product-categories.products.index');
        Route::post('/product-categories/{productCategory}/products', [
            ProductCategoryProductsController::class,
            'store',
        ])->name('product-categories.products.store');

        Route::apiResource('suppliers', SupplierController::class);

        // Supplier Products
        Route::get('/suppliers/{supplier}/products', [
            SupplierProductsController::class,
            'index',
        ])->name('suppliers.products.index');
        Route::post('/suppliers/{supplier}/products', [
            SupplierProductsController::class,
            'store',
        ])->name('suppliers.products.store');

        Route::apiResource('products', ProductController::class);

        // Product Historical Prices
        Route::get('/products/{product}/historical-prices', [
            ProductHistoricalPricesController::class,
            'index',
        ])->name('products.historical-prices.index');
        Route::post('/products/{product}/historical-prices', [
            ProductHistoricalPricesController::class,
            'store',
        ])->name('products.historical-prices.store');

        // Product Sites
        Route::get('/products/{product}/sites', [
            ProductSitesController::class,
            'index',
        ])->name('products.sites.index');
        Route::post('/products/{product}/sites/{site}', [
            ProductSitesController::class,
            'store',
        ])->name('products.sites.store');
        Route::delete('/products/{product}/sites/{site}', [
            ProductSitesController::class,
            'destroy',
        ])->name('products.sites.destroy');

        // Product Sellables
        Route::get('/products/{product}/sellables', [
            ProductSellablesController::class,
            'index',
        ])->name('products.sellables.index');
        Route::post('/products/{product}/sellables/{sellable}', [
            ProductSellablesController::class,
            'store',
        ])->name('products.sellables.store');
        Route::delete('/products/{product}/sellables/{sellable}', [
            ProductSellablesController::class,
            'destroy',
        ])->name('products.sellables.destroy');

        Route::apiResource('sellables', SellableController::class);

        // Sellable Products
        Route::get('/sellables/{sellable}/products', [
            SellableProductsController::class,
            'index',
        ])->name('sellables.products.index');
        Route::post('/sellables/{sellable}/products/{product}', [
            SellableProductsController::class,
            'store',
        ])->name('sellables.products.store');
        Route::delete('/sellables/{sellable}/products/{product}', [
            SellableProductsController::class,
            'destroy',
        ])->name('sellables.products.destroy');
    });

// Route::webhooks('location-created', 'location-created');
// Route::webhooks('location-updated', 'location-updated');