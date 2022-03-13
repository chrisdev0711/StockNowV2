<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SellableController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SquareController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockTakeController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SquareApiController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/login');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('sites', SiteController::class);
        Route::resource('zones', ZoneController::class);
        Route::resource('product-categories', ProductCategoryController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('products', ProductController::class);
        Route::resource('sellables', SellableController::class);
        Route::resource('ingredients', IngredientController::class);
        Route::resource('users', UserController::class);
        // Route::resource('orders', OrderController::class);

        Route::get('stockreport', [ProductController::class, 'newindex'])->name('products.newindex');

        Route::get('fetchVatRates', [SquareController::class, 'fetchVatRates'])->name('square.fetchVatRates');
        Route::get('fetchCategories', [SquareController::class, 'fetchCategories'])->name('square.fetchCategories');
        Route::get('fetchLocations', [SquareController::class, 'fetchLocations'])->name('square.fetchLocations');
        Route::get('fetchSellables', [SquareController::class, 'fetchSellables'])->name('square.fetchSellables');
        Route::get('fetchSales', [SquareController::class, 'fetchSales'])->name('square.fetchSales');

        Route::post('importSuppliers', [SupplierController::class, 'importSuppliers'])->name('suppliers.import');
        Route::get('importSuppliersView', [SupplierController::class, 'importSuppliersView'])->name('suppliers.importView');
        Route::post('importProducts', [ProductController::class, 'importProducts'])->name('products.import');
        Route::get('importProductsView', [ProductController::class, 'importProductsView'])->name('products.importView');

        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('orders/addToCart', [OrderController::class, 'addToCart'])->name('orders.addToCart');
        Route::get('orders/clearCart', [OrderController::class, 'clearCart'])->name('orders.clearCart');
        Route::get('orders/viewCart', [OrderController::class, 'viewCart'])->name('orders.viewCart');
        Route::post('orders/updateOne', [OrderController::class, 'updateOne'])->name('orders.updateOne');
        Route::post('orders/removeOne', [OrderController::class, 'removeOne'])->name('orders.removeOne');
        Route::get('orders/confirmOrder', [OrderController::class, 'confirmOrder'])->name('orders.confirmOrder');
        Route::get('orders/history', [OrderController::class, 'history'])->name('orders.history');
        Route::get('orders/send', [OrderController::class, 'send'])->name('orders.send');
        Route::get('orders/viewmail', [OrderController::class, 'viewmail'])->name('orders.viewmail');
        
        Route::get('orders/detail', [OrderController::class, 'detail'])->name('orders.detail');
        Route::post('orders/update', [OrderController::class, 'update'])->name('orders.update');
        Route::post('orders/updateItem', [OrderController::class, 'updateItem'])->name('orders.updateItem');
        Route::post('orders/destroy', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::post('orders/removeItem', [OrderController::class, 'removeItem'])->name('orders.removeItem');
        Route::get('orders/receive', [OrderController::class, 'receive'])->name('orders.receive');
        Route::get('orders/receiveItem', [OrderController::class, 'receiveItem'])->name('orders.receiveItem');
        Route::post('orders/receiveConfirm', [OrderController::class, 'receiveConfirm'])->name('orders.receiveConfirm');
        Route::post('orders/receiveAll', [OrderController::class, 'receiveAll'])->name('orders.receiveAll');

        Route::get('stockTakes/filter', [StockTakeController::class, 'filter'])->name('stockTakes.filter');
        Route::post('stockTakes/create', [StockTakeController::class, 'create'])->name('stockTakes.create');
        Route::get('stockTakes/stockCounts', [StockTakeController::class, 'stockCounts'])->name('stockTakes.stockCounts');
        Route::post('stockTakes/adjust', [StockTakeController::class, 'adjust'])->name('stockTakes.adjust');
        Route::get('stockTakes/removeStockTake', [StockTakeController::class, 'removeStockTake'])->name('stockTakes.removeStockTake');
        Route::get('stockTakes/complete', [StockTakeController::class, 'complete'])->name('stockTakes.complete');
        Route::get('stockTakes/history', [StockTakeController::class, 'history'])->name('stockTakes.history');
        Route::get('stockTakes/approve', [StockTakeController::class, 'approve'])->name('stockTakes.approve');
        Route::get('stockTakes/detail', [StockTakeController::class, 'detail'])->name('stockTakes.detail');
        Route::post('stockTakes/destroy', [StockTakeController::class, 'destroy'])->name('stockTakes.destroy');
        Route::get('stockTakes/deleteStockTake', [StockTakeController::class, 'deleteStockTake'])->name('stockTakes.deleteStockTake');

        Route::get('purchase_order_list', [PurchaseOrderController::class, 'index'])->name('purchase_order_list');
        Route::get('check_square', [SquareApiController::class, 'index'])->name('check_square');
        Route::post('save_square', [SquareApiController::class, 'save_data'])->name('save_square');
    });

Route::webhooks('location-created', 'location-created');
Route::webhooks('location-updated', 'location-updated');
