<?php


use App\Models\Error;
use App\Models\PastError;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\IpToLocationController;
use App\Http\Controllers\PasswordChangeController;


Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/home');
    } else {
        return view('users/login');
    }
});

//Random
Route::get('/home', [DataController::class, 'home'])->middleware('auth');
Route::get('/admin', [DataController::class, 'admin'])->middleware('auth')->middleware('rank');
Route::get('/dashboard', [DataController::class, 'dashboard'])->middleware('auth');
Route::get('/static', [DataController::class, 'static'])->middleware('auth');

Route::post('/settings/update', [SettingsController::class, 'update'])->middleware('auth')->middleware('rank');

//Data
Route::middleware(['auth', 'rank'])->group(function () {
    Route::get('/hostData', [DataController::class, 'hostData']);
    Route::get('/providerData', [DataController::class, 'providerData']);
    Route::get('/pingData', [DataController::class, 'pingData']);
    Route::get('/staticData', [DataController::class, 'staticData'])->name('staticData');;
});
//Users
Route::post('/users', [UserController::class, 'store']);
Route::middleware(['guest'])->group(function () {
    Route::post('/users/authenticate', [UserController::class, 'authenticate']);
    Route::get('/users/register', [UserController::class, 'create']);
    Route::get('/users/login', [UserController::class, 'login'])->name('login');
});
Route::middleware(['auth'])->group(function () {
    Route::post('/users/update', [UserController::class, 'update']);
    Route::get('/users/logout', [UserController::class, 'logout']);
    Route::get('/account-settings', [UserController::class, 'accountSettings'])->name('account.settings');
});

    //Hosts
Route::middleware(['auth', 'rank'])->group(function () {
    Route::post('/hosts', [HostController::class, 'store']);
    Route::get('/host/edit/{host}', [HostController::class, 'showEdit']);
    Route::get('/host/create', [HostController::class, 'showCreate']);
    Route::get('/host/{host}', [HostController::class, 'show'])->name('host.info')->where('host', '[A-Za-z0-9_.]+');
    Route::get('/host/delete/{host}', [HostController::class, 'destroy']);
    Route::post('/host/update', [HostController::class, 'update']);

    //Providers
    Route::post('/providers', [ProviderController::class, 'store']);
    Route::get('/provider/delete/{provider}', [ProviderController::class, 'destroy']);
    Route::get('/provider/create', [ProviderController::class, 'showCreate']);
});
//Maps
Route::get('/map', [IpToLocationController::class, 'getLocation'])->middleware('auth');
Route::get('/legacymap', [IpToLocationController::class, 'legacymap'])->middleware('auth');

//Mail
Route::get('/send', [MailController::class, 'index']);
Route::post('/send-mail', [MailController::class, 'sendMail'])->name('send.mail');

//Change Password
Route::get('/password/change', [PasswordChangeController::class, 'showChangeForm'])->name('password.change');
Route::post('/password/change', [PasswordChangeController::class, 'changePassword'])->name('password.change');

Route::get('/forgotpass', function () {
    return view('users/forgotpassword');
});

Route::get('/resetpassword', function () {
    return view('users/resetpass');
});

Route::get('/errors/delete', function (request $request) {
    Error::where('id', $request->id)->delete();
    return redirect('/dashboard')->with('message', 'Error deleted successfully');
})->middleware('auth');

Route::get('/PastErrors/delete', function (request $request) {
    PastError::where('id', $request->id)->delete();
    return redirect('/dashboard')->with('message', 'Old Error deleted successfully');
})->middleware('auth');
