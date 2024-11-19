<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusniessProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogOrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientRequestController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomDesignController;
use App\Http\Controllers\CustomOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PatternController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Permission\RolesPermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalesRepresentativeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\GalleryImageController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\StaffScheduleController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\TryTestController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ProductSizeController;
use App\Models\StaffSchedule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//clothing shop
Route::get("/stripe-success", [StripeController::class, "success"])->name("stripe-success");
Route::get("/stripe-cancel", [StripeController::class, "cancel"])->name("stripe-cancel");

Route::middleware('mailverified')->group(function () {


    Route::get('/', function () {
        // return view('layouts.frontend.master');
        return view('frontend.home');
    })->name('home');
    // Route::get('/', function() {
    //     return response()->json([
    //      'stuff' => phpinfo()
    //     ]);
    //  });
    //dropzone
    Route::post('projects/media', [ProjectsController::class, 'storeMedia'])->name('projects.storeMedia');
    Route::post('save-dropzone-image', [ProductController::class, 'dropzoneImage'])->name('save-dropzone-image');
    Route::get('/search-products', [ProductController::class, 'searchProducts'])->name('search-products');
    Route::get('/get-product-details', [ProductController::class, 'getProductDetails'])->name('get-product-details');



    Route::resource('buy-bulk', MerchandiseController::class);

    Route::resource('custom-order', CustomOrderController::class);
    Route::post('/check-email', [CustomOrderController::class, 'checkEmail'])->name('check.email');
    Route::resource('catalog-order', CatalogOrderController::class);
    Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);
    Route::resource('custom-product-design', CustomDesignController::class);

    Route::resource('home', HomeController::class);
    Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact');
    Route::post('/contact-us/send', [ContactController::class, 'sendContactForm'])->name('contact.send');

    Route::resource('shop', ShopController::class);
    Route::get('shop/products/{category_id}/{gender}/', [ShopController::class, 'products'])->name('shop.products');

    Route::get('/product-details/{id}', [ShopController::class, 'productDetails'])->name('shop.details');
    Route::get('/product-cart', [ShopController::class, 'productCart'])->name('shop.product-cart');
    Route::get('/custom-design', [ShopController::class, 'customDesign'])->name('shop.custom-design');
    // Route::get('/custom-order', [ShopController::class, 'customOrder'])->name('shop.custom-order');

    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/reorder/{order}', [CartController::class, 'reorder'])->name('cart.reorder');


    Route::get('/product-checkout', [ShopController::class, 'productCheckout'])->name('shop.product-checkout');
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->middleware(['auth', 'verified'])->name('dashboard');
    Route::post('/increment-quantity', [ProductController::class, 'incrementQuantity'])->name('increment-quantity');
    Route::post('/decrement-quantity',  [ProductController::class, 'decrementQuantity'])->name('decrement-quantity');
    Route::post('/save-canvas-image',  [ProductController::class, 'saveCanvasImage'])->name('save-canvas-image');
    Route::post('/save-canvas-mockup',  [ProductController::class, 'saveCanvasMockup'])->name('save-canvas-mockup');
    Route::post('/delete-canvas-image',  [ProductController::class, 'deleteCanvasImage'])->name('delete-canvas-image');
    //clothing shop

});

Route::get('/dashboard', function () {
    if (Auth::user()->hasRole('User')) {
        $userId = Auth::id();
        return redirect()->route('home')->with('message', 'login successFully!');
    }
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {


    Route::get('messages', [MessagesController::class, 'index'])->name('messages.index');
    Route::get('messages/outbox', [MessagesController::class, 'outbox'])->name('messages.outbox');
    Route::get('messages/create', [MessagesController::class, 'create'])->name('messages.create');
    Route::get('messages/{id}',  [MessagesController::class, 'show'])->name('messages.show');
    Route::post('messages',  [MessagesController::class, 'store'])->name('messages.store');
    Route::post('messages/update/{id}',  [MessagesController::class, 'update'])->name('messages.update');
    Route::post('messages/{id}/reply',  [MessagesController::class, 'reply'])->name('messages.reply');

    Route::get('/autocomplete', [MessagesController::class, 'autocomplete'])->name('autocomplete');

    Route::resource('order', OrderController::class);
    Route::resource('admin-order', AdminOrderController::class);
    Route::post('/order/{orderId}/update-status', [AdminOrderController::class, 'updateOrderStatus']);


    Route::resource('user-profile', UserProfileController::class);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('client-request/create', [ClientRequestController::class, 'create'])->name('client_request.create')->middleware('permission:client_request.add');
    Route::post('client-request/store', [ClientRequestController::class, 'store'])->name('client_request.store')->middleware('permission:client_request.add');
    Route::get('client-request/edit/{id}', [ClientRequestController::class, 'edit'])->name('client_request.edit')->middleware('permission:client_request.edit');
    Route::post('client-request/update/{id}', [ClientRequestController::class, 'update'])->name('client_request.update')->middleware('permission:client_request.edit');
    Route::get('client-request/index', [ClientRequestController::class, 'index'])->name('client_request.index')->middleware('permission:client_request.view');
    Route::post('client-request/destroy/{id}', [ClientRequestController::class, 'destroy'])->name('client_request.destroy')->middleware('permission:client_request.delete');

    // Route::resource('client', ClientController::class);
    Route::get('client/create', [ClientController::class, 'create'])->name('client.create')->middleware('permission:client.add');
    Route::get('client/request', [ClientController::class, 'createRequest'])->name('client.request')->middleware('permission:client.view');
    Route::post('client/store', [ClientController::class, 'store'])->name('client.store')->middleware('permission:client.add');
    Route::get('client/edit/{client}', [ClientController::class, 'edit'])->name('client.edit')->middleware('permission:client.edit');
    Route::put('client/update/{client}', [ClientController::class, 'update'])->name('client.update')->middleware('permission:client.edit');
    Route::get('client/index', [ClientController::class, 'index'])->name('client.index')->middleware('permission:client.view');
    Route::get('my-requests', [ClientController::class, 'userIndex'])->name('user.index')->middleware('permission:client.add');
    Route::delete('client/destroy/{client}', [ClientController::class, 'destroy'])->name('client.destroy')->middleware('permission:client.delete');

    Route::resource('pattern', PatternController::class);
    Route::get('product/inventory/list', [InventoryController::class, 'productInventoryList'])->name('product.inventory.list')->middleware('permission:product.add');
    Route::get('create/inventory/{product_id}', [InventoryController::class, 'createInventory'])->name('create.inventory')->middleware('permission:product.add');
    Route::get('product/inventories/{product_id}', [InventoryController::class, 'productInventories'])->name('product.inventories')->middleware('permission:product.add');
    Route::resource('inventory', InventoryController::class);
    Route::resource('productSize', ProductSizeController::class);

    Route::get('product/create', [ProductController::class, 'create'])->name('product.create')->middleware('permission:product.add');
    Route::get('product/request', [ProductController::class, 'createRequest'])->name('product.request')->middleware('permission:product.view');
    Route::post('product/store', [ProductController::class, 'store'])->name('product.store')->middleware('permission:product.add');
    Route::get('product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit')->middleware('permission:product.edit');
    Route::put('product/update/{product}', [ProductController::class, 'update'])->name('product.update')->middleware('permission:product.edit');
    Route::get('product/index', [ProductController::class, 'index'])->name('product.index')->middleware('permission:product.view');
    Route::get('my-requests', [ProductController::class, 'userIndex'])->name('user.index')->middleware('permission:product.add');
    Route::delete('product/destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy')->middleware('permission:product.delete');

    Route::get('contact-us/index', [ContactController::class, 'index'])->name('contact-us.index')->middleware('permission:contact_us.view');
    Route::get('contact-us/show', [ContactController::class, 'show'])->name('contact-us.show')->middleware('permission:contact_us.view');


    Route::get('category/create', [CategoryController::class, 'create'])->name('category.create')->middleware('permission:category.add');
    Route::get('category/request', [CategoryController::class, 'createRequest'])->name('category.request')->middleware('permission:category.view');
    Route::post('category/store', [CategoryController::class, 'store'])->name('category.store')->middleware('permission:category.add');
    Route::get('category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit')->middleware('permission:category.edit');
    Route::put('category/update/{category}', [CategoryController::class, 'update'])->name('category.update')->middleware('permission:category.edit');
    Route::get('category/index', [CategoryController::class, 'index'])->name('category.index')->middleware('permission:category.view');
    Route::get('my-requests', [CategoryController::class, 'userIndex'])->name('user.index')->middleware('permission:category.add');
    Route::delete('category/destroy/{category}', [CategoryController::class, 'destroy'])->name('category.destroy')->middleware('permission:category.delete');

    Route::get('business/create', [BusinessController::class, 'create'])->name('business.create')->middleware('permission:business.add');
    Route::post('business/store', [BusinessController::class, 'store'])->name('business.store')->middleware('permission:business.add');
    Route::get('business/edit/{business}', [BusinessController::class, 'edit'])->name('business.edit')->middleware('permission:business.edit');
    Route::put('business/update/{business}', [BusinessController::class, 'update'])->name('business.update')->middleware('permission:business.edit');
    Route::get('business/index', [BusinessController::class, 'index'])->name('business.index')->middleware('permission:business.view');
    Route::delete('business/destroy/{business}', [BusinessController::class, 'destroy'])->name('business.destroy')->middleware('permission:business.delete');

    Route::get('color/create', [ColorController::class, 'create'])->name('color.create')->middleware('permission:color.add');
    Route::post('color/store', [ColorController::class, 'store'])->name('color.store')->middleware('permission:color.add');
    Route::get('color/edit/{color}', [ColorController::class, 'edit'])->name('color.edit')->middleware('permission:color.edit');
    Route::put('color/update/{color}', [ColorController::class, 'update'])->name('color.update')->middleware('permission:color.edit');
    Route::get('color/index', [ColorController::class, 'index'])->name('color.index')->middleware('permission:color.view');
    Route::delete('color/destroy/{color}', [ColorController::class, 'destroy'])->name('color.destroy')->middleware('permission:color.delete');

    // Route::resource('business', BusinessController::class);

    Route::get('/client-status/{client_id}', [ClientController::class, 'status'])->name('client.status')->middleware('permission:client.approve');
    Route::get('/business-status/{business_id}', [BusinessController::class, 'status'])->name('business.status')->middleware('permission:business.approve');

    Route::get('permission/create', [PermissionController::class, 'create'])->name('permission.create')->middleware('permission:permission.add');
    Route::get('permission/index', [PermissionController::class, 'index'])->name('permission.index');
    Route::post('permission/store', [PermissionController::class, 'store'])->name('permission.store')->middleware('permission:permission.add');
    Route::get('permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit')->middleware('permission:permission.edit');
    Route::post('permission/destroy/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy')->middleware('permission:permission.delete');
    Route::post('permission/update/{id}', [PermissionController::class, 'update'])->name('permission.update')->middleware('permission:permission.edit');

    Route::get('role/create', [RoleController::class, 'create'])->name('role.create')->middleware('permission:permission.add');
    Route::get('role/index', [RoleController::class, 'index'])->name('role.index');
    Route::post('role/store', [RoleController::class, 'store'])->name('role.store')->middleware('permission:role.add');
    Route::get('role/edit/{role}', [RoleController::class, 'edit'])->name('role.edit')->middleware('permission:role.edit');
    Route::post('role/destroy/{role}', [RoleController::class, 'destroy'])->name('role.destroy')->middleware('permission:role.delete');
    Route::post('role/update/{role}', [RoleController::class, 'update'])->name('role.update')->middleware('permission:role.edit');

    Route::get('roles-permission/create', [RolesPermissionController::class, 'create'])->name('roles-permission.create')->middleware('permission:roles_permission.add');
    Route::get('roles-permission/index', [RolesPermissionController::class, 'index'])->name('roles-permission.index')->middleware('permission:roles_permission.view');
    Route::post('roles-permission/store', [RolesPermissionController::class, 'store'])->name('roles-permission.store')->middleware('permission:roles_permission.add');
    Route::get('roles-permission/edit/{roles_permission}', [RolesPermissionController::class, 'edit'])->name('roles-permission.edit')->middleware('permission:roles_permission.edit');
    Route::post('roles-permission/destroy/{roles_permission}', [RolesPermissionController::class, 'destroy'])->name('roles-permission.destroy')->middleware('permission:roles_permission.add');
    Route::post('roles-permission/update/{roles_permission}', [RolesPermissionController::class, 'update'])->name('roles-permission.update')->middleware('permission:roles_permission.edit');

    Route::get('admin/create', [AdminController::class, 'create'])->name('admin.create')->middleware('permission:admin.add');
    Route::post('admin/store', [AdminController::class, 'store'])->name('admin.store')->middleware('permission:admin.add');
    Route::get('admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit')->middleware('permission:admin.edit');
    Route::post('admin/update/{id}', [AdminController::class, 'update'])->name('admin.update')->middleware('permission:admin.edit');
    Route::get('admin/index', [AdminController::class, 'index'])->name('admin.index')->middleware('permission:admin.view');
    Route::post('admin/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy')->middleware('permission:admin.delete');

    Route::get('sales-representative/create', [SalesRepresentativeController::class, 'create'])->name('sales-representative.create')->middleware('permission:sales_representative.add');
    Route::post('sales-representative/store', [SalesRepresentativeController::class, 'store'])->name('sales-representative.store')->middleware('permission:sales_representative.add');
    Route::get('sales-representative/edit/{id}', [SalesRepresentativeController::class, 'edit'])->name('sales-representative.edit')->middleware('permission:sales_representative.edit');
    Route::post('sales-representative/update/{id}', [SalesRepresentativeController::class, 'update'])->name('sales-representative.update')->middleware('permission:sales_representative.edit');
    Route::get('sales-representative/index', [SalesRepresentativeController::class, 'index'])->name('sales-representative.index')->middleware('permission:sales_representative.view');
    Route::post('sales-representative/destroy/{id}', [SalesRepresentativeController::class, 'destroy'])->name('sales-representative.destroy')->middleware('permission:sales_representative.delete');
    // Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create')->middleware('permission:staff.add');
    // Route::post('staff/store', [StaffController::class, 'store'])->name('staff.store');
    Route::post('staff/store', [StaffController::class, 'store'])->name('staff.store')->middleware('permission:staff.add');
    Route::get('staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit')->middleware('permission:staff.edit');
    Route::post('staff/update/{id}', [StaffController::class, 'update'])->name('staff.update')->middleware('permission:staff.edit');
    Route::get('staff/index', [StaffController::class, 'index'])->name('staff.index')->middleware('permission:staff.view');
    Route::post('staff/destroy/{id}', [StaffController::class, 'destroy'])->name('staff.destroy')->middleware('permission:staff.delete');

    Route::get('shift/create', [ShiftController::class, 'create'])->name('shift.create');
    // Route::get('shift/create', [ShiftController::class, 'create'])->name('shift.create')->middleware('permission:shift.add');
    Route::post('shift/store', [ShiftController::class, 'store'])->name('shift.store');
    // Route::post('shift/store', [ShiftController::class, 'store'])->name('shift.store')->middleware('permission:shift.add');
    Route::get('shift/edit/{id}', [ShiftController::class, 'edit'])->name('shift.edit')->middleware('permission:shift.edit');
    Route::post('shift/update', [ShiftController::class, 'update'])->name('shift.update')->middleware('permission:shift.edit');
    Route::get('/get-shift-data', [ShiftController::class, 'getShiftData'])->name('get.shift.data');

    Route::get('shift/index', [ShiftController::class, 'index'])->name('shift.index')->middleware('permission:shift.view');
    Route::post('shift/destroy/{id}', [ShiftController::class, 'destroy'])->name('shift.destroy')->middleware('permission:shift.delete');

    // Route::get('staffschedule/create', [StaffScheduleController::class, 'create'])->name('staffschedule.create');
    Route::get('staffschedule/create', [StaffScheduleController::class, 'create'])->name('staffschedule.create')->middleware('permission:staffschedule.add');
    // Route::post('staffschedule/store', [StaffScheduleController::class, 'store'])->name('staffschedule.store');
    Route::post('staffschedule/store', [StaffScheduleController::class, 'store'])->name('staffschedule.store')->middleware('permission:staffschedule.add');
    Route::get('staffschedule/edit/{id}', [StaffScheduleController::class, 'edit'])->name('staffschedule.edit')->middleware('permission:staffschedule.edit');

    Route::get('/get-schedule-data', [StaffScheduleController::class, 'getSchedulData'])->name('get.schedule.data');

    Route::post('staffschedule/update', [StaffScheduleController::class, 'update'])->name('staffschedule.update')->middleware('permission:staffschedule.edit');
    Route::get('staffschedule/index', [StaffScheduleController::class, 'index'])->name('staffschedule.index')->middleware('permission:staffschedule.view');
    Route::post('staffschedule/destroy/{id}', [StaffScheduleController::class, 'destroy'])->name('staffschedule.destroy')->middleware('permission:staffschedule.delete');

    Route::resource('gallery-images', GalleryImageController::class);
    Route::get('gallery-images/create/{product_id}', [GalleryImageController::class, 'createimages'])->name('gallery-images.createimages');
    Route::post('save-gallery-image', [GalleryImageController::class, 'galleryImage'])->name('save-gallery-image');
});

// use for test
Route::resource('test', TryTestController::class);
require __DIR__ . '/auth.php';
