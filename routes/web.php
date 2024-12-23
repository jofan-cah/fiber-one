<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\OltController;
use App\Http\Controllers\OdpController;
use App\Http\Controllers\OdcController;
use App\Http\Controllers\SubscriptionController;
use App\Models\Odc;
use App\Models\Odp;
use Illuminate\Http\Request;

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

// Dashboard
Route::get('/', [Controller::class, 'index'])->name('home')->middleware('auth');

// Maintenance
Route::group(['middleware' => ['auth']], function () {

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('indexUsers');
        Route::post('/', [UserController::class, 'store'])->name('storeUsers');
        Route::get('/create', [UserController::class, 'create'])->name('createUsers');
        Route::get('/allData', [UserController::class, 'getAllData'])->name('getAllDataUsers');
        Route::get('/edit/{id}', [UserController::class, 'show'])->name('editUsersById');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('updateUsers');

        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroyUsers');
    });

    Route::prefix('/level')->group(function () {
        Route::get('/', [UserLevelController::class, 'index'])->name('indexUsersLevel');
        Route::get('/create', [UserLevelController::class, 'create'])->name('createUsersLevel');
        Route::get('/allData', [UserLevelController::class, 'getAllData'])->name('getAllDataUsersLevel');
        Route::get('/{id}', [UserLevelController::class, 'edit'])->name('showUsersLevel');
        Route::put('/update/{id}', [UserLevelController::class, 'update'])->name('updateUsersLevel');
        Route::get('/edit/{id}', [UserLevelController::class, 'show'])->name('editUsersLevelById');
        Route::post('/', [UserLevelController::class, 'store'])->name('storeUsersLevel');
        Route::delete('/{id}', [UserLevelController::class, 'destroy'])->name('destroyUsersLevel');
    });

    Route::prefix('/olt')->group(function () {
        Route::get('/', [OltController::class, 'index'])->name('indexOlt');
        Route::get('/create', [OltController::class, 'create'])->name('createOlt');
        Route::get('/allData', [OltController::class, 'getAllData'])->name('getAllDataOlt');
        Route::get('/{id}', [OltController::class, 'showOlt'])->name('showOlt');
        Route::put('/update/{id}', [OltController::class, 'update'])->name('updateOlt');
        Route::get('/edit/{id}', [OltController::class, 'show'])->name('editOltById');
        Route::post('/', [OltController::class, 'store'])->name('storeOlt');
        Route::delete('/{id}', [OltController::class, 'destroy'])->name('destroyOlt');
    });

    Route::prefix('/subs')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('indexSubs');
        Route::get('/create', [SubscriptionController::class, 'create'])->name('createSubs');
        Route::get('/allData', [SubscriptionController::class, 'getAllData'])->name('getAllDataSubs');
        Route::get('/{id}', [SubscriptionController::class, 'showSubs'])->name('showSubs');
        Route::put('/update/{id}', [SubscriptionController::class, 'update'])->name('updateSubs');
        Route::get('/edit/{id}', [SubscriptionController::class, 'show'])->name('editSubsById');
        Route::post('/', [SubscriptionController::class, 'store'])->name('storeSubs');
        Route::delete('/{id}', [SubscriptionController::class, 'destroy'])->name('destroySubs');
    });

    Route::prefix('/odp')->group(function () {
        Route::get('/', [OdpController::class, 'index'])->name('indexOdp');
        Route::get('/create', [OdpController::class, 'create'])->name('createOdp');
        Route::get('/allData', [OdpController::class, 'getAllData'])->name('getAllDataOdp');
        Route::get('/{id}', [OdpController::class, 'showOdp'])->name('showOdp');
        Route::put('/update/{id}', [OdpController::class, 'update'])->name('updateOdp');
        Route::get('/edit/{id}', [OdpController::class, 'show'])->name('editOdpById');
        Route::post('/', [OdpController::class, 'store'])->name('storeOdp');
        Route::delete('/{id}', [OdpController::class, 'destroy'])->name('destroyOdp');
    });

    Route::prefix('/odc')->group(function () {
        Route::get('/', [OdcController::class, 'index'])->name('indexOdc');
        Route::get('/create', [OdcController::class, 'create'])->name('createOdc');
        Route::get('/allData', [OdcController::class, 'getAllData'])->name('getAllDataOdc');
        Route::get('/{id}', [OdcController::class, 'showOdc'])->name('showOdc');
        Route::put('/update/{id}', [OdcController::class, 'update'])->name('updateOdc');
        Route::get('/edit/{id}', [OdcController::class, 'show'])->name('editOdcById');
        Route::post('/', [OdcController::class, 'store'])->name('storeOdc');
        Route::delete('/{id}', [OdcController::class, 'destroy'])->name('destroyOdc');
    });

    Route::prefix('/coverage')->group(function () {
        Route::get('/', [OltController::class, 'coverage'])->name('coverage');
        Route::get('/site', [OltController::class, 'site'])->name('site');
        Route::post('/coverage/search', [OltController::class, 'searchNearest'])->name('coverageSearch');
        Route::get('/getOdp',  [OltController::class, 'getOdp'])->name('getOdp');
    });

    Route::prefix('/site')->group(function () {
        Route::get('/', [OltController::class, 'allSite'])->name('allSite');


        Route::get('/get-odcs-by-olt', [OltController::class, 'getOlts'])->name('get.odcs.by.olt');
        Route::get('/get-odps-by-odc', [OltController::class, 'getOdcs'])->name('get.odps.by.odc');
        Route::get('/filter-data', [OltController::class, 'filterDataALl'])->name('filterData');

        Route::get('/topology', [OltController::class, 'topology'])->name('topology');
        Route::get('/topology-data', [OltController::class, 'getTopologyData'])->name('topologyData');
    });
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'logged'])->name('logged')->middleware('throttle:50,1');
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
