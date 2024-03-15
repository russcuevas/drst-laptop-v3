<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AnalyticsController;
use App\Http\Controllers\admin\InvoiceController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ReportsController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\staff\StaffAnalyticsController;
use App\Http\Controllers\staff\StaffController;
use App\Http\Controllers\staff\StaffReportsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


////////////////////////// PUBLIC PAGE /////////////////////////////////
// PUBLIC PAGE
Route::get('/', [HomeController::class, 'HomePage'])->name('homepage');
Route::get('/home', [HomeController::class, 'HomePage'])->name('homepage');
Route::get('/view/product/{id}', [HomeController::class, 'SingleProductPage'])->name('product.details');
Route::get('/shop', [ShopController::class, 'ShopPage'])->name('shoppage');
Route::get('/shop/filter', [ShopController::class, 'FilterByGrain'])->name('shopgrain');
Route::get('/contact', [ContactController::class, 'ContactPage'])->name('contactpage');
Route::post('/contact/submit', [ContactController::class, 'SendEmail'])->name('send_inquiry');
//////////////////////////  END /////////////////////////////////


// CUSTOMERS REQUEST

// MY PROFILE
Route::get('/myprofile', [ProfileController::class, 'MyProfilePage'])->name('myprofilepage');
Route::post('/myprofile/update_request', [ProfileController::class, 'UpdateMyProfileRequest'])->name('updatemyprofilerequest');

// CART
Route::post('/cart/add', [CartController::class, 'AddToCartRequest'])->name('cart.add');
Route::get('/view/cart', [CartController::class, 'ViewCart'])->name('view.cart');
Route::delete('/delete-cart/{cart_id}', [CartController::class, 'DeleteCart'])->name('delete.cart');
Route::get('/delete-all-cart', [CartController::class, 'DeleteAllCart'])->name('delete.allcart');
Route::post('/update-quantity', [CartController::class, 'UpdateQuantityCart'])->name('update.quantity.cart');

// CHECKOUT
Route::get('/checkout', [CheckoutController::class, 'CheckoutPage'])->name('checkoutpage');
Route::post('/checkout/request', [CheckoutController::class, 'CheckoutRequest'])->name('checkoutrequest');

// ORDERS
Route::get('/my_orders', [MyOrderController::class, 'MyOrderPage'])->name('myorderpage');
Route::get('/my_orders/{ReferenceNumber}', [MyOrderController::class, 'ShowMyOrders'])
    ->name('myordershow');
Route::post('/cancel-myorders', [MyOrderController::class, 'CancelMyOrders'])->name('cancel-myorders');






////////////////////////// AUTH /////////////////////////////////
// AUTH PAGE
Route::get('/login', [AuthController::class, 'LoginPage'])->name('loginpage');
Route::get('/registration', [AuthController::class, 'RegisterPage'])->name('registerpage');

// AUTH REQUEST
Route::post('/loginrequest', [AuthController::class, 'LoginRequest'])->name('loginrequest');
Route::get('/logout', [AuthController::class, 'Logout'])->name('logoutrequest');
Route::post('/registrationrequest', [AuthController::class, 'RegisterRequest'])->name('register.request');
////////////////////////// -END- /////////////////////////////////




////////////////////////// ADMIN /////////////////////////////////
// ADMIN DASHBOARD
Route::get('/admin/admin_dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
Route::get('/admin/update_profile', [AdminController::class, 'UpdateProfile'])->name('admin.updateprofile');
Route::post('/admin/update_profilerequest', [AdminController::class, 'UpdateProfileRequest'])->name('admin.updateprofilerequest');

// ADMIN DASHBOARD USER CRUD
Route::get('/admin/admin_users', [UserController::class, 'UserPage'])->name('admin.users');
Route::get('/admin/admin_addusers', [UserController::class, 'AddUserPage'])->name('admin.addusers');
Route::post('/admin/adduser_request', [UserController::class, 'AddUserRequest'])->name('admin.addusersrequest');
// ADMIN UPDATE USER PAGE
Route::get('/admin/admin_update-user/{id}', [UserController::class, 'UpdateUserPage'])->name('admin.updateusers');
// ADMIN UPDATE USER REQUEST
Route::put('/admin/admin_update-users/{id}', [UserController::class, 'UpdateUserRequest'])->name('admin.updateusersrequest');
// ADMIN DELETE USER REQUEST
Route::get('/admin/admin_delete-user/{id}', [UserController::class, 'DeleteUserRequest'])->name('admin.deleteusersrequest');


// ADMIN DASHBOARD PRODUCT CRUD
Route::get('/admin/admin_products', [ProductController::class, 'ProductPage'])->name('admin.products');
Route::get('/admin/admin_addproducts', [ProductController::class, 'AddProductPage'])->name('admin.addproducts');
Route::post('/admin/addproduct_request', [ProductController::class, 'AddProductRequest'])->name('admin.addproductsrequest');
// ADMIN UPDATE PRODUCT PAGE
Route::get('/admin/admin_update-product/{id}', [ProductController::class, 'UpdateProductPage'])->name('admin.updateproducts');
// ADMIN UPDATE PRODUCT REQUEST
Route::put('/admin/admin_update-products/{id}', [ProductController::class, 'UpdateProductRequest'])->name('admin.updateproductsrequest');
// ADMIN DELETE PRODUCT REQUEST
Route::get('/admin/admin_delete-product/{id}', [ProductController::class, 'DeleteProductRequest'])->name('admin.deleteproductsrequest');

// ADMIN DASHBOARD ORDERS
Route::get('/admin/admin_orders', [OrderController::class, 'OrderPage'])->name('admin.orders');
Route::get('/admin/orders/{ReferenceNumber}/{InvoiceNumber}', [OrderController::class, 'ShowOrdersByReferenceAndInvoice'])
    ->name('admin.orders.show');
Route::post('/update-orders-status/{referenceNumber}/{invoiceNumber}', [OrderController::class, 'updateOrdersStatus'])->name('updateOrdersStatus');
Route::get('/candel-order/{referenceNumber}/{invoiceNumber}', [OrderController::class, 'CancelOrder'])->name('cancelorder');
Route::get('/delete-order/{referenceNumber}/{invoiceNumber}', [OrderController::class, 'DeleteCompletedOrder'])->name('deletecompleted');


// ADMIN INVOICE ORDERS
Route::get('/admin/admin_invoice', [InvoiceController::class, 'InvoicePage'])->name('admin.invoice');
Route::get('/admin/show-invoice/{InvoiceNumber}', [InvoiceController::class, 'ShowInvoice'])->name('admin.invoice.show');



// ADMIN REPORTS ORDERS
Route::get('/admin/admin_reports', [ReportsController::class, 'ReportsPage'])->name('admin.reports');
Route::get('/admin/admin_delete_reports/{id}', [ReportsController::class, 'DeleteReport'])->name('admin.deletereports');
Route::get('/admin/generate-reports/{type}', [ReportsController::class, 'GenerateReports'])->name('admin.generateReports');


// ADMIN ANALYTICS
Route::get('/admin/admin_analytics', [AnalyticsController::class, 'AnalyticsPage'])->name('admin.analytics');
Route::get('/weekly-sales', [AnalyticsController::class, 'GetWeeklySales'])->name('get-weekly-sales');
Route::get('/monthly-sales', [AnalyticsController::class, 'GetMonthlySales'])->name('get-monthly-sales');
Route::get('/yearly-sales', [AnalyticsController::class, 'GetYearlySales'])->name('yearly-sales');
Route::get('/top-products', [AnalyticsController::class, 'GetTopProducts'])->name('get-top-products');
////////////////////////// -END- /////////////////////////////////



////////////////////////// STAFF /////////////////////////////////
// STAFF DASHBOARD
Route::get('/staff/staff_dashboard', [StaffController::class, 'StaffDashboard'])->name('staff.dashboard');
Route::get('/staff/myprofile', [StaffController::class, 'UpdateProfileStaff'])->name('staff.updatepage');
Route::post('/staff/myprofile/update_request', [StaffController::class, 'UpdateProfileStaffRequest'])->name('staff.updaterequest');

// STAFF REPORTS
Route::get('/staff/staff_reports', [StaffReportsController::class, 'ReportsPage'])->name('staff.reports');
Route::get('/generate-reports/{type}', [StaffReportsController::class, 'GenerateReports'])->name('staff.generateReports');

// STAFF ANALYTICS
Route::get('/staff/staff_analytics', [StaffAnalyticsController::class, 'AnalyticsPage'])->name('staff.analytics');
Route::get('/staff-weekly-sales', [StaffAnalyticsController::class, 'GetWeeklySales'])->name('staff-get-weekly-sales');
Route::get('/staff-monthly-sales', [StaffAnalyticsController::class, 'GetMonthlySales'])->name('staff-get-monthly-sales');
Route::get('/staff-yearly-sales', [StaffAnalyticsController::class, 'GetYearlySales'])->name('staff-yearly-sales');
Route::get('/staff-top-products', [StaffAnalyticsController::class, 'GetTopProducts'])->name('staff-get-top-products');
////////////////////////// -END- /////////////////////////////////
