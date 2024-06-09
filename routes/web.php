<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\FreeGiftController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\GiftRecordController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MembershipController;



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

Route::get('/', [VisitorController::class, 'store']);

Route::get('/login', function () {
    return view('user/login');
})->name('login');;

Route::get('logout', function () {
    Session::forget('user');
    session()->flush();
    return redirect('/login');
});

Route::get('/forget_password', function () {
    return view('user/forgetPassword');
});

Route::view('/register','user/register');
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/searchKeyword', [UserController::class, 'searchKeyword']);
Route::post('/searchProduct', [UserController::class, 'searchProduct']);
Route::get('/reviews', [ReviewController::class, 'review_page'])->name('reviews');
Route::post('/forget_password', [UserController::class, 'forgetPassword']);
Route::post('/submitResetPasswordForm', [UserController::class, 'submitResetPasswordForm']);
Route::get('user/reset_password/{token}/{email}', [UserController::class, 'verify_reset_password'])->name('reset_password');
Route::get('/auth/google', [UserController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [UserController::class, 'handleGoogleCallback']);
Route::resource('products', ProductController::class);
Route::get('/product_details/{id}', [ProductController::class, 'details'])->name('products.details');
Route::get('/filter', [ProductController::class, 'filterByMake'])->name('filterByMake');
Route::get('/addToCart/{id}', [ProductController::class, 'addToCart']);
Route::resource('comments', ReviewController::class);


Route::prefix('user')->middleware(['auth'])->group(function () {
    // Only authenticated users can access this route
    Route::get('/edit-profile', [UserController::class, 'edit_profile']);
    Route::post('/submitEditProfileForm/{id}', [UserController::class, 'submitEditProfileForm']);
    Route::get('/sell', function () {
        return view('user/sell');
    });
    Route::get('/changePassword', [UserController::class, 'changePassword']);
    Route::post('/verify_card_info', [PaymentController::class, 'verify_card_info']);
    Route::get('/myCarsOnBid', [ProductController::class, 'myCarsOnBid']);
    Route::get('/sendOTP/{phoneNumber}', [UserController::class, 'sendOTP']);
    Route::get('/validateOTP/{otp}', [UserController::class, 'validateOTP']);
    Route::post('/edit_password/{id}', [UserController::class, 'edit_password']);
    Route::get('/reviews/{reviewId}/like', [ReviewController::class, 'like']);
    Route::get('/cart', [ProductController::class, 'cart'])->name('products.cart');
    Route::get('/deleteCart/{id}', [ProductController::class, 'deleteCart'])->name('products.deleteCart');
    Route::get('/checkout/{selectedOrderIds}', [PaymentController::class, 'displayPayment'])->name('payment.display');
    Route::post('/payment', [PaymentController::class, 'createPayment'])->name('payment.create');
    Route::get('/payment-history', [PaymentController::class, 'displayPaymentHistory'])->name('payment.displayHistory');
    Route::get('/destroyProduct/{id}', [ProductController::class, 'destroyProduct']);

    
});

Route::prefix('admin')->middleware(['auth', 'isStafforAdmin'])->group(function(){
    //only admin can do
    Route::get('/allStaffs', [UserController::class, 'indexStaff'])->name('staffs.all');
    Route::get('/admin_portal', [DashboardController::class, 'index']);
    Route::get('/membershipDetails/{level}', [MembershipController::class, 'membershipDetails'])->name('membershipDetails');
    Route::get('/membershipAllDetails', [MembershipController::class, 'membershipAllDetails'])->name('membershipAllDetails');
    Route::get('/delivery', [PaymentController::class, 'delivery']);
    Route::get('/delivery/{id}', [PaymentController::class, 'edit_delivery'])->name('delivery.edit');
    Route::post('/delivery/{id}', [PaymentController::class, 'update_delivery'])->name('delivery.update');
    Route::get('/monthlySales', [PaymentController::class, 'monthlySales_report'])->name('monthlySales');
    Route::get('/userDemographic', [UserController::class, 'userDemographic_report'])->name('userDemographic');
    Route::get('/commentAnalysis', [ReviewController::class, 'commentAnalysis_report'])->name('commentAnalysis');
    Route::resource('customers', UserController::class);
    Route::resource('staffs', UserController::class);
    Route::resource('memberships', MembershipController::class);
    Route::get('/deleteUser/{id}', [UserController::class, 'destroyUser']);
    Route::get('/deleteReview/{id}', [ReviewController::class, 'destroyReview']);
    Route::get('/admin/all-product', [ProductController::class, 'admin'])->name('products.admin');
    Route::resource('payments', PaymentController::class);
    Route::get('/deletePayment/{id}', [PaymentController::class, 'destroyPayment']);
    
    Route::apiResource('freegifts', FreeGiftController::class, ['names' => 'freegifts']);
    Route::get('/freegifts/create/new', [FreeGiftController::class, 'create'])->name('freegifts.create');//to fix create modify to show by using /new
    Route::get('/freegifts/edit/{id}', [FreeGiftController::class, 'edit'])->name('freegifts.edit');
    Route::get('/deleteGift/{id}', [FreeGiftController::class, 'destroyGift']);

    Route::apiResource('gift-records', GiftRecordController::class, ['names' => 'giftRecords']);
    Route::get('/gift-records/create/new', [GiftRecordController::class, 'create'])->name('giftRecords.create');//to fix create modify to show by using /new
    Route::get('/gift-records/edit/{id}', [GiftRecordController::class, 'edit'])->name('giftRecords.edit');
    Route::get('/deleteGiftRecords/{id}', [GiftRecordController::class, 'destroyGiftRecord']);

});

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function(){
    Route::get('/allStaffs', [UserController::class, 'indexStaff'])->name('staffs.all');
    Route::resource('staffs', UserController::class);

});


    