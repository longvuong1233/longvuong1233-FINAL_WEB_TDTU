<?php

use App\Http\Controllers\assignmentApiController;
use App\Http\Controllers\assignmentClassRoomController;
use App\Http\Controllers\classDetailsController;
use App\Http\Controllers\classroomApiController;
use App\Http\Controllers\classroomController;
use App\Http\Controllers\classStoreController;
use App\Http\Controllers\commentClassController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\mailController;
use App\Http\Controllers\peopleAndClassController;

use App\Http\Controllers\userController;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


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

Route::get('/', function () {
    return redirect("/login");
});


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
    Route::get('/demo', function () {
        return view('welcome');
    });
    Route::resource('classroom', classroomController::class);
    Route::resource('classroomapi', classroomApiController::class);
    Route::get("showlistclassroom", function () {
        return view("listClassroomPermission");
    })->name("listClassroomPermission");
    Route::resource('peopleAndClass', peopleAndClassController::class);



    Route::resource('classDetails', classDetailsController::class);
    Route::resource('classStore', classStoreController::class);
    Route::get("/commentClass", [commentClassController::class, 'getComment']);
    Route::post("/commentClass", [commentClassController::class, 'comment']);
    Route::delete("/commentClass", [commentClassController::class, 'deleteComment']);



    Route::post("assignment", [assignmentClassRoomController::class, "submitAssignment"])->name("submitassignment");
    Route::get("/assignment/{id_class}", [assignmentClassRoomController::class, "submitAgain"])->name("submitagain");

    Route::post("/inviteJoinClass", [mailController::class, "inviteClass"])->name("inviteClass");
    Route::post("/askingJoinClass", [mailController::class, "askingJoinClass"])->name("askingJoinClass");
    Route::resource('user', userController::class);
    Route::get('getfile/{id}', function ($id) {
        $dir = '/';
        $recursive = false;
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));
        $file = $contents
            ->where('type', '=', 'file')
            ->where('basename', '=', $id)
            ->first();
        $rawData = Storage::cloud()->get($file['path']);
        return response($rawData, 200)
            ->header('Content-Type', $file['mimetype'])
            ->header('Content-Disposition', "attachment; filename=" . $file["name"]);
    })->name("getfile");
});