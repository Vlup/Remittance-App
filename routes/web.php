<?php

use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VerificationController;

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
Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/', function () {
        $user = User::with('vouchers')->where('id', Auth::user()->id)->first();
        return view('pages.home', compact('user'));
    });
    
    Route::get('/profile', function () {
        $user = User::with('vouchers')->where('id', Auth::user()->id)->first();
        return view('pages.profile', compact('user'));
    });

    Route::get('/voucher', function () {
        $promos = Voucher::all();
        return view('pages.voucher', compact('promos'));
    });

    Route::get('/history', [TransactionController::class, 'index']);
    
    Route::post('/promos', [PromoController::class, 'store'])->middleware('verified');
    
    Route::post('/logout', [AuthController::class, 'logout']);
})->withoutMiddleware('verified');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'get_login'])->name('login');
    Route::get('/register', [AuthController::class, 'get_register'])->name('register');
    Route::post('/login', [AuthController::class, 'post_login']);
    Route::post('/register', [AuthController::class, 'post_register']);
});

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verify/resend-verification', [VerificationController::class, 'send'])->middleware(['auth', 'throttle:5,1'])->name('verification.send');

Route::post('/transactions', [TransactionController::class, 'store'])->middleware(['auth', 'auth.session', 'verified']);



